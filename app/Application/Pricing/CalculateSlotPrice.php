<?php

namespace App\Application\Pricing;

use App\Domain\Pricing\PricingCalculator;
use App\Domain\Pricing\PriceRule;
use App\Domain\Pricing\TimeRange;
use App\Infrastructure\Persistence\Repositories\PriceRuleRepository;

/**
 * 📌 Đây là điểm nối duy nhất giữa:
DB
Domain
Booking (sau này)
 */
class CalculateSlotPrice
{
  public function __construct(
    private PriceRuleRepository $priceRuleRepo,
    private PricingCalculator $calculator
  ) {}

  public function execute(CalculateSlotPriceCommand $command): array {
    $rules = $this->priceRuleRepo->getByCourt($command->courtId);

    // $domainRules = array_map(
    //   fn($rule) => new PriceRule(
    //     $rule->day_of_week,
    //     new TimeRange((string) $rule->start_time, (string) $rule->end_time),
    //     (int) $rule->price_per_hour,
    //     (string) $rule->rule_type,
    //     (int) $rule->priority
    //   ),
    //   $rules
    // );

    $domainRules = $rules->map(function ($rule) {
      return new PriceRule(
        $rule->day_of_week,
        new TimeRange(
          (string) $rule->start_time,
          (string) $rule->end_time
        ),
        (int) $rule->price_per_hour,
        (string) $rule->rule_type,
        (int) $rule->priority
      );
    })->all(); // 🔑 convert sang array CHỈ khi đưa vào Domain

    $matchedRule = $this->calculator->calculate(
      $domainRules,
      $command->date,
      $command->slotStart,
      $command->slotEnd
    );

    return [
      'price' => $matchedRule->price(),
      'rule'  => $matchedRule->type(),
    ];
  }
}
