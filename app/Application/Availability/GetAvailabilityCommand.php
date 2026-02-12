<?php

namespace App\Application\Availability;

final class GetAvailabilityCommand
{
  public function __construct(
    public readonly int $courtId,
    public readonly string $date
  ) {}
}
