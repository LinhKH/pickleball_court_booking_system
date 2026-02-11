<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Court;
use App\Models\CourtUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
  protected $model = Booking::class;

  public function definition(): array
  {
    return [
      'user_id'       => User::factory(),
      'court_id'      => Court::factory(),
      'court_unit_id' => CourtUnit::factory(),
      'total_price'   => 200_000,
      'status'        => 'pending',
    ];
  }
}
