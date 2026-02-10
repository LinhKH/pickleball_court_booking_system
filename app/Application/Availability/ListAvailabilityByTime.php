<?php

namespace App\Application\Availability;

use App\Application\Pricing\CalculateSlotPrice;
use App\Application\Pricing\CalculateSlotPriceCommand;
use App\Infrastructure\Availability\SlotLocker;
use App\Infrastructure\Persistence\Repositories\CourtUnitSlotRepository;

class ListAvailabilityByTime
{
  public function __construct(
    private CourtUnitSlotRepository $slotRepo,
    private SlotLocker $locker,
    private CalculateSlotPrice $pricing
  ) {}

  public function execute(int $courtId, string $date): array
  {
    $slots = $this->slotRepo->getByCourtAndDate($courtId, $date);

    $grouped = [];

    foreach ($slots as $slot) {
      $timeKey = substr($slot->start_time, 0, 5) . '-' . substr($slot->end_time, 0, 5);

      if (! isset($grouped[$timeKey])) {
        $priceInfo = $this->pricing->execute(
          new CalculateSlotPriceCommand(
            courtId: $courtId,
            date: $date,
            slotStart: substr($slot->start_time, 0, 5),
            slotEnd: substr($slot->end_time, 0, 5),
          )
        );

        $grouped[$timeKey] = [
          'time'            => $timeKey,
          'price'           => $priceInfo['price'],
          'rule'            => $priceInfo['rule'],
          'court_units'     => [],
          'available_units' => 0,
        ];
      }

      // status
      $locked = $this->locker->isLocked(
        $slot->court_unit_id,
        $slot->date,
        substr($slot->start_time, 0, 5)
      );

      if ($slot->status === 'available' && ! $locked) {
        $grouped[$timeKey]['court_units'][] = [
          'id'   => $slot->courtUnit->id,
          'name' => $slot->courtUnit->name,
        ];
        $grouped[$timeKey]['available_units']++;
      }
    }

    return array_values($grouped);
  }
}
