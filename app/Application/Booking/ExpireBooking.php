<?php

namespace App\Application\Booking;

use App\Infrastructure\Availability\SlotLocker;
use App\Infrastructure\Persistence\Repositories\BookingRepository;

final class ExpireBooking
{
  public function __construct(
    private BookingRepository $bookingRepo,
    private SlotLocker $locker
  ) {}

  public function execute(): void
  {
    $bookings = $this->bookingRepo->getExpiredPending();

    foreach ($bookings as $booking) {
      $booking->expire();
      $this->bookingRepo->updateStatus($booking);

      // release slot lock
      foreach ($this->bookingRepo->getSlots($booking->id()) as $slot) {
        $this->locker->release(
          $slot->court_unit_id,
          $slot->date,
          $slot->start_time
        );
      }
    }
  }
}
