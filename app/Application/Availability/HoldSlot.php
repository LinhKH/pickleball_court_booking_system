<?php

namespace App\Application\Availability;

use App\Domain\Availability\SlotPolicy;
use App\Infrastructure\Availability\SlotLocker;
use App\Infrastructure\Persistence\Repositories\SlotRepository;
use DomainException;

// Use Case
final class HoldSlot
{
  public function __construct(
    private SlotRepository $slotRepo,
    private SlotPolicy $policy,
    private SlotLocker $locker
  ) {}

  public function execute(HoldSlotCommand $command): void
  {
    $slot = $this->slotRepo->find($command->slotId);

    // Domain rule
    $this->policy->ensureBookable($slot);

    // Redis lock
    $locked = $this->locker->lock(
      $command->courtUnitId,
      $command->date,
      $command->startTime,
      $command->userId
    );

    if (! $locked) {
      throw new DomainException('Slot is already locked');
    }
  }
}
