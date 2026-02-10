<?php

namespace App\Application\Availability;

use App\Application\Pricing\CalculateSlotPrice;
use App\Application\Pricing\CalculateSlotPriceCommand;
use App\Infrastructure\Availability\SlotLocker;
use App\Infrastructure\Persistence\Repositories\SlotRepository;

final class ListSlots
{
  public function __construct(
    private SlotRepository $slotRepo,
    private SlotLocker $locker,
    private CalculateSlotPrice $pricing
  ) {}
  /**📌 Quan trọng
Pricing được gọi ở Application
Domain không biết Redis
Redis không biết Pricing */
  public function execute(ListSlotsCommand $command): array
  {
    $slots = $this->slotRepo->getByCourtAndDate(
      $command->courtId,
      $command->date
    );

    return $slots->map(function ($slot) use ($command) {

      // 1️⃣ determine status
      if ($slot->status === 'booked') {
        $status = 'booked';
      } elseif ($this->locker->isLocked($command->courtId, $slot->id)) {
        $status = 'locked';
      } else {
        $status = 'available';
      }

      // 2️⃣ pricing
      $priceInfo = $this->pricing->execute(
        new CalculateSlotPriceCommand(
          courtId: $command->courtId,
          date: $command->date,
          slotStart: substr($slot->start_time, 0, 5),
          slotEnd: substr($slot->end_time, 0, 5)
        )
      );

      return [
        'slot_id'    => $slot->id,
        'start_time' => substr($slot->start_time, 0, 5),
        'end_time'   => substr($slot->end_time, 0, 5),
        'status'     => $status,
        'price'      => $priceInfo['price'],
        'price_rule' => $priceInfo['rule'],
      ];
    })->all();
  }
}
