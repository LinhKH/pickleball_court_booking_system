<?php

namespace App\Domain\Pricing;

/**
 * 📌 Vai trò:

Đại diện 1 rule giá

Tự biết khi nào nó áp dụng
 */
final class PriceRule
{
  public function __construct(
    private ?int $dayOfWeek,   // 1–7 | null = all
    private TimeRange $timeRange,
    private int $pricePerHour,
    private string $type,      // day / night / peak
    private int $priority
  ) {}

  public function matches(
    string $date,
    string $slotStart,
    string $slotEnd
  ): bool {
    $day = (int) date('N', strtotime($date));

    return ($this->dayOfWeek === null || $this->dayOfWeek === $day) && $this->timeRange->contains($slotStart, $slotEnd);
  }

  public function price(): int
  {
    return $this->pricePerHour;
  }

  public function type(): string
  {
    return $this->type;
  }

  public function priority(): int
  {
    return $this->priority;
  }
}
