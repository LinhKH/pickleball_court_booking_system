<?php

namespace App\Domain\Booking;

class BookingPolicy
{
  public function ensureCanCreate(bool $hasLock): void
  {
    if (! $hasLock) {
      throw new BookingException('Slot must be locked before booking');
    }
  }
}
