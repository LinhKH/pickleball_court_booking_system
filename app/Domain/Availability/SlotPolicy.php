<?php

namespace App\Domain\Availability;

use DomainException;

final class SlotPolicy
{
  public function ensureBookable(Slot $slot): void
  {
    if ($slot->status() !== SlotStatus::Available) {
      throw new DomainException('Slot is not available');
    }
  }
}
