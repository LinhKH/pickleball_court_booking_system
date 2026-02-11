<?php

namespace Database\Factories;

use App\Models\CourtUnit;
use App\Models\Court;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourtUnitFactory extends Factory
{
  protected $model = CourtUnit::class;

  public function definition(): array
  {
    return [
      'court_id' => Court::factory(),
      'name' => 'Court ' . $this->faker->randomElement(['A', 'B', 'C']),
      'status' => 'active',
    ];
  }
}
