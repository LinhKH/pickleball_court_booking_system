<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Court;
use App\Models\CourtUnit;

class CourtUnitSeeder extends Seeder
{
  public function run(): void
  {
    $courts = Court::all();

    foreach ($courts as $court) {
      foreach (['Court A', 'Court B', 'Court C'] as $name) {
        CourtUnit::firstOrCreate([
          'court_id' => $court->id,
          'name'     => $name,
        ], [
          'status' => 'active',
        ]);
      }
    }
  }
}
