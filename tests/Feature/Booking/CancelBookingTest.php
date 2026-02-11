<?php

namespace Tests\Feature\Booking;

use App\Application\Booking\CancelBooking;
use App\Infrastructure\Availability\SlotLocker;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CancelBookingTest extends TestCase
{
  use RefreshDatabase;

  public function test_pending_booking_can_be_cancelled(): void
  {
    // 1️⃣ MOCK SlotLocker (quan trọng)
    $this->mock(SlotLocker::class, function ($mock) {
      $mock->shouldReceive('release')
        ->zeroOrMoreTimes(); // cancel có thể release nhiều slot
    });

    // 2️⃣ Create booking
    $booking = Booking::factory()->create([
      'status' => 'pending',
    ]);

    // 3️⃣ Execute use case
    app(CancelBooking::class)->execute($booking->id);

    // 4️⃣ Assert
    $booking->refresh();
    $this->assertEquals('cancelled', $booking->status);
  }
}
