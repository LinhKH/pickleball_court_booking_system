<?php

namespace App\Domain\Pricing;

use App\Models\CourtSlot;
use App\Models\CourtPriceRule;
use Carbon\Carbon;

class PricingService
{
  public function calculate(int $courtId, string $date, array $slotIds): array
  {
    $slots = CourtSlot::whereIn('id', $slotIds)->get();

    $rules = CourtPriceRule::where('court_id', $courtId)
      ->where('is_active', true)
      ->orderByDesc('priority')
      ->get();

    $results = [];

    foreach ($slots as $slot) {
      $priceRule = $this->matchRule($rules, $slot, $date);

      $results[] = [
        'court_slot_id' => $slot->id,
        'start_time' => $slot->start_time,
        'end_time' => $slot->end_time,
        'price' => $priceRule->price_per_hour,
        'rule_type' => $priceRule->rule_type,
      ];
    }

    return $results;
  }

  protected function matchRule($rules, CourtSlot $slot, string $date)
  {
    $dayOfWeek = Carbon::parse($date)->dayOfWeekIso; // 1–7

    foreach ($rules as $rule) {
      if (
        ($rule->day_of_week === null || $rule->day_of_week === $dayOfWeek) &&
        $slot->start_time >= $rule->start_time &&
        $slot->end_time <= $rule->end_time
      ) {
        return $rule;
      }
    }

    throw new \Exception('No pricing rule matched');
  }
}
