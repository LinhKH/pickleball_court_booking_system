<?php

namespace Tests\Feature\Booking;

use App\Application\Booking\ExpireBooking;
use App\Infrastructure\Availability\SlotLocker;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class ExpireBookingTest extends TestCase
{
  use RefreshDatabase;

  public function test_pending_booking_is_expired_after_ttl(): void
  {
    // 1️⃣ Mock SlotLocker (giống Cancel/Pay)
    $this->mock(SlotLocker::class, function ($mock) {
      $mock->shouldReceive('release')
        ->zeroOrMoreTimes();
    });

    // 2️⃣ Fix time
    Carbon::setTestNow(now());

    // 3️⃣ Create pending booking quá hạn
    $booking = Booking::factory()->create([
      'status' => 'pending',
      'created_at' => now()->subMinutes(10),
    ]);

    // 4️⃣ Execute use case
    app(ExpireBooking::class)->execute();

    // 5️⃣ Assert DB state (KHÔNG gọi domain method)
    $booking->refresh();

    $this->assertEquals('expired', $booking->status);
  }
}
