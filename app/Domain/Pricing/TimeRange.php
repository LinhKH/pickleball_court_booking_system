<?php

namespace App\Domain\Pricing;

/**
 * 📌 Vai trò:

Gói logic thời gian

Không so sánh time rải rác trong code
 */
class TimeRange
{
  public function __construct(
    public string $start, // H:i format
    public string $end // H:i format
  ) {}

  private function normalize(string $time): string
  {
    return strlen($time) === 5 ? $time . ':00' : $time;
  }

  public function contains(string $slotStart, string $slotEnd): bool
  {
    $slotStart = $this->normalize($slotStart);
    $slotEnd   = $this->normalize($slotEnd);
    return $slotStart >= $this->start && $slotEnd <= $this->end;
  }
}
