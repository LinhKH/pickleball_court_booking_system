<?php

namespace Tests\Feature\Booking;

use App\Application\Payment\PayBooking;
use App\Application\Payment\PayBookingCommand;
use App\Models\Booking;
use App\Models\BookingSlot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayBookingTest extends TestCase
{
  use RefreshDatabase;

  public function test_booking_can_be_paid(): void
  {
    $booking = Booking::factory()->create([
      'status' => 'pending',
      'total_price' => 300_000,
    ]);

    BookingSlot::factory()->create([
      'booking_id' => $booking->id,
      'court_unit_id' => 1,
      'date' => '2026-02-10',
      'start_time' => '18:00',
    ]);

    app(PayBooking::class)->execute(
      new PayBookingCommand($booking->id)
    );

    $booking->refresh();

    $this->assertEquals('paid', $booking->status);
  }
}
