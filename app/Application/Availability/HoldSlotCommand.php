<?php

namespace App\Application\Availability;

final class HoldSlotCommand
{
  public function __construct(
    public readonly int $courtUnitId,
    public readonly string $date,
    public readonly string $startTime,
    public readonly int $userId
  ) {}
}
