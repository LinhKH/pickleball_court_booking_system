<?php

namespace Database\Factories;

use App\Models\Court;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourtFactory extends Factory
{
  protected $model = Court::class;

  public function definition(): array
  {
    return [
      'owner_id' => User::factory(),
      'name' => 'Pickleball Court ' . $this->faker->city(),
      'description' => $this->faker->paragraph(),
      'address' => $this->faker->address(),
      'lat' => $this->faker->latitude(),
      'lng' => $this->faker->longitude(),
      'open_time' => '06:00',
      'close_time' => '22:00',
      'status' => 'active',
    ];
  }
}
