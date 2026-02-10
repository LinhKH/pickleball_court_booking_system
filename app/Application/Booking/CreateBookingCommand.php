<?php

namespace App\Application\Booking;

final class CreateBookingCommand
{
  public function __construct(
    public readonly int $userId,
    public readonly int $courtId,
    public readonly int $courtUnitId,
    public readonly string $date,
    public readonly array $slots // [{ start_time, price }]
    
  ) {}
}
