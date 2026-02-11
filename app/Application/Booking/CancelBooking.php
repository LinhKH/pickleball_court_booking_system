<?php

namespace App\Application\Booking;

use App\Infrastructure\Availability\SlotLocker;
use App\Infrastructure\Persistence\Repositories\BookingRepository;

final class CancelBooking
{
  public function __construct(
    private BookingRepository $bookingRepo,
    private SlotLocker $locker
  ) {}

  public function execute(int $bookingId): void
  {
    $booking = $this->bookingRepo->findDomain($bookingId);

    $booking->cancel();
    $this->bookingRepo->updateStatus($booking);

    foreach ($this->bookingRepo->getSlots($bookingId) as $slot) {
      $this->locker->release(
        $slot->court_unit_id,
        $slot->date,
        $slot->start_time
      );
    }
  }
}
