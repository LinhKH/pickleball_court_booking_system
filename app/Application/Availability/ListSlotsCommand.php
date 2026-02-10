<?php

namespace App\Application\Availability;

final class ListSlotsCommand
{
  public function __construct(
    public readonly int $courtId,
    public readonly string $date
  ) {}
}
