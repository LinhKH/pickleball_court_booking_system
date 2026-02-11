<?php

namespace Tests\Feature\Availability;

use App\Application\Availability\HoldSlot;
use App\Application\Availability\HoldSlotCommand;
use App\Infrastructure\Availability\SlotLocker;
use Tests\TestCase;

class HoldSlotTest extends TestCase
{
  public function test_user_can_hold_slot(): void
  {
    // 1️⃣ MOCK TRƯỚC
    $this->mock(SlotLocker::class, function ($mock) {
      $mock->shouldReceive('lock')
        ->once()
        ->andReturn(true);
    });

    // 2️⃣ RESOLVE SAU
    $useCase = app(HoldSlot::class);

    // 3️⃣ EXECUTE
    $useCase->execute(
      new HoldSlotCommand(
        courtUnitId: 1,
        date: '2026-02-10',
        startTime: '18:00',
        userId: 1
      )
    );

    // 4️⃣ ASSERT
    $this->assertTrue(true);
  }
}
