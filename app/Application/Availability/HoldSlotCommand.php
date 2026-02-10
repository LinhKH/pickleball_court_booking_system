<?php

namespace App\Application\Availability;

final class HoldSlotCommand
{
  public function __construct(
    public readonly int $courtId,
    public readonly int $slotId,
    public readonly int $userId
  ) {}
}
