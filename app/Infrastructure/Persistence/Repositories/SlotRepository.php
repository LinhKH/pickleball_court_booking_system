<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Availability\Slot;
use App\Domain\Availability\SlotStatus;
use App\Models\CourtSlot;

class SlotRepository
{
  public function find(int $slotId): Slot
  {
    $slot = CourtSlot::findOrFail($slotId);

    return new Slot(
      $slot->id,
      SlotStatus::from($slot->status)
    );
  }
}
