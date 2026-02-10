<?php
namespace Database\Seeders;
use App\Models\CourtSlot;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CourtSlotSeeder extends Seeder
{
  public function run(): void
  {
    $courtId = 1;
    $slotMinutes = 60;

    for ($d = 0; $d < 7; $d++) {
      $date = Carbon::today()->addDays($d);

      $start = Carbon::parse('06:00');
      $end   = Carbon::parse('23:00');

      while ($start < $end) {
        CourtSlot::firstOrCreate([
          'court_id'   => $courtId,
          'date'       => $date->toDateString(),
          'start_time' => $start->format('H:i'),
        ], [
          'end_time'   => $start->copy()->addMinutes($slotMinutes)->format('H:i'),
          'status'     => 'available',
        ]);

        $start->addMinutes($slotMinutes);
      }
    }
  }
}
