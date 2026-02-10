<?php

namespace App\Application\Booking;

use App\Domain\Booking\Booking;
use App\Domain\Booking\BookingPolicy;
use App\Infrastructure\Availability\SlotLocker;
use App\Infrastructure\Persistence\Repositories\BookingRepository;
use DomainException;

/**
📌 Booking chỉ tạo nếu slot đang bị lock
📌 Domain không biết Redis
📌 Redis chỉ check trong Application
 */
final class CreateBooking
{
  public function __construct(
    private SlotLocker $locker,
    private BookingPolicy $policy,
    private BookingRepository $bookingRepo
  ) {}

  public function execute(CreateBookingCommand $command)
  {
    // 1️⃣ verify all slots are locked by user
    foreach ($command->slots as $slot) {
      $locked = $this->locker->isLockedBy(
        $command->courtUnitId,
        $command->date,
        $slot['start_time'],
        $command->userId
      );

      $this->policy->ensureCanCreate($locked);
    }

    // 2️⃣ create domain booking
    $booking = new Booking(
      $command->userId,
      $command->courtId,
      $command->courtUnitId
    );

    foreach ($command->slots as $slot) {
      $booking->addSlot($slot['price']);
    }

    // 3️⃣ persist
    return $this->bookingRepo->save($booking);
  }
}
