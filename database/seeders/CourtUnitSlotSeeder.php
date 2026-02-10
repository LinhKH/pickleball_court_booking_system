<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourtUnit;
use App\Models\CourtUnitSlot;
use Carbon\Carbon;

class CourtUnitSlotSeeder extends Seeder
{
  public function run(): void
  {
    $startHour = 6;
    $endHour   = 22;
    $daysAhead = 7;

    $units = CourtUnit::where('status', 'active')->get();

    foreach ($units as $unit) {
      for ($d = 0; $d < $daysAhead; $d++) {

        $date = Carbon::today()->addDays($d)->toDateString();

        for ($hour = $startHour; $hour < $endHour; $hour++) {

          $start = sprintf('%02d:00:00', $hour);
          $end   = sprintf('%02d:00:00', $hour + 1);

          CourtUnitSlot::firstOrCreate([
            'court_unit_id' => $unit->id,
            'date'          => $date,
            'start_time'    => $start,
          ], [
            'end_time' => $end,
            'status'   => 'available',
          ]);
        }
      }
    }
  }
}
