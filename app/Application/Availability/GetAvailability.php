<?php

namespace App\Application\Availability;

use App\Repositories\CourtUnitRepository;
use App\Repositories\BookingSlotRepository;
use App\Infrastructure\Availability\SlotLocker;
use App\Domain\Pricing\PricingService;

final class GetAvailability
{
  public function __construct(
    private CourtUnitRepository $courtUnitRepo,
    private BookingSlotRepository $bookingSlotRepo,
    private SlotLocker $locker,
    private PricingService $pricing
  ) {}

  public function execute(GetAvailabilityCommand $command): array
  {
    $courtUnits = $this->courtUnitRepo->findByCourt($command->courtId);

    $results = [];

    foreach ($courtUnits as $unit) {
      $slots = [];

      foreach ($this->generateTimeSlots($unit->court->open_time, $unit->court->close_time) as $time) {
        $isBooked = $this->bookingSlotRepo->exists(
          $unit->id,
          $command->date,
          $time
        );

        $isLocked = $this->locker->isLocked(
          $unit->id,
          $command->date,
          $time
        );

        $slots[] = [
          'time' => $time,
          'price' => $this->pricing->priceFor(
            $unit->id,
            $time,
            $command->date
          ),
          'available' => ! $isBooked && ! $isLocked,
        ];
      }

      $results[] = [
        'court_unit_id' => $unit->id,
        'court_unit_name' => $unit->name,
        'slots' => $slots,
      ];
    }

    return $results;
  }

  private function generateTimeSlots(string $open, string $close): array
  {
    $slots = [];
    $current = strtotime($open);
    $end = strtotime($close);

    while ($current < $end) {
      $slots[] = date('H:i', $current);
      $current = strtotime('+1 hour', $current);
    }

    return $slots;
  }
}
