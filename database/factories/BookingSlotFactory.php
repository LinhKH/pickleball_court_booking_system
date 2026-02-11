<?php

namespace Database\Factories;

use App\Models\BookingSlot;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingSlotFactory extends Factory
{
  protected $model = BookingSlot::class;

  public function definition(): array
  {
    return [
      'booking_id'    => Booking::factory(),
      'court_unit_id' => 1,
      'date'          => '2026-02-10',
      'start_time'    => '18:00',
      'price'         => 200_000,
    ];
  }
}
