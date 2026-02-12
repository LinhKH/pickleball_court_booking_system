<?php

namespace Tests\Feature\Availability;

use App\Infrastructure\Availability\SlotLocker;
use App\Models\Court;
use App\Models\CourtUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAvailabilityTest extends TestCase
{
  use RefreshDatabase;

  public function test_can_get_availability(): void
  {
    $court = Court::factory()->create([
      'open_time' => '18:00',
      'close_time' => '20:00',
    ]);

    CourtUnit::factory()->create([
      'court_id' => $court->id,
      'name' => 'Court A',
    ]);

    $this->mock(SlotLocker::class, function ($mock) {
      $mock->shouldReceive('isLocked')
        ->andReturn(false);
    });

    $response = $this->getJson('/api/v1/availability?court_id=' . $court->id . '&date=2026-02-10');

    $response
      ->assertStatus(200)
      ->assertJsonStructure([
        [
          'court_unit_id',
          'court_unit_name',
          'slots' => [
            [
              'time',
              'price',
              'available',
            ]
          ]
        ]
      ]);
  }
}
