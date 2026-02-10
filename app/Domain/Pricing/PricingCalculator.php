<?php

namespace App\Domain\Pricing;
// Domain Service
//👉 Domain hoàn toàn không biết DB là gì
final class PricingCalculator
{
  /**
   * @param PriceRule[] $rules (đã sort theo priority desc)
   */
  public function calculate(
    array $rules,
    string $date,
    string $slotStart,
    string $slotEnd
  ): PriceRule {
    foreach ($rules as $rule) {
      if ($rule->matches($date, $slotStart, $slotEnd)) {
        return $rule;
      }
    }

    throw new PricingException('No pricing rule matched');
  }
}
