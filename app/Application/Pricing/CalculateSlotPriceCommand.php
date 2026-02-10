<?php

namespace App\Application\Pricing;

final class CalculateSlotPriceCommand
{
  public function __construct(
    public readonly int $courtId,
    public readonly string $date,      // Y-m-d
    public readonly string $slotStart, // H:i or H:i:s
    public readonly string $slotEnd    // H:i or H:i:s
  ) {}
}
/**📌 Ghi chú:

readonly (PHP 8.2) → immutable
Command = dữ liệu, không logic */