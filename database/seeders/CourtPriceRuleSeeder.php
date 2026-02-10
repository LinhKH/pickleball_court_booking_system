<?php
namespace Database\Seeders;
use App\Models\CourtPriceRule;
use Illuminate\Database\Seeder;

class CourtPriceRuleSeeder extends Seeder
{
    public function run(): void
    {
        $courtId = 1;

        // Ca ngày
        CourtPriceRule::create([
            'court_id'       => $courtId,
            'day_of_week'    => null,
            'start_time'     => '06:00',
            'end_time'       => '18:00',
            'price_per_hour' => 120000,
            'rule_type'      => 'day',
            'priority'       => 1,
        ]);

        // Ca tối
        CourtPriceRule::create([
            'court_id'       => $courtId,
            'day_of_week'    => null,
            'start_time'     => '18:00',
            'end_time'       => '23:00',
            'price_per_hour' => 180000,
            'rule_type'      => 'night',
            'priority'       => 2,
        ]);

        // Peak hour (18h–21h)
        CourtPriceRule::create([
            'court_id'       => $courtId,
            'day_of_week'    => null,
            'start_time'     => '18:00',
            'end_time'       => '21:00',
            'price_per_hour' => 220000,
            'rule_type'      => 'peak',
            'priority'       => 3,
        ]);

        // Weekend (Sat & Sun)
        foreach ([6, 7] as $day) {
            CourtPriceRule::create([
                'court_id'       => $courtId,
                'day_of_week'    => $day,
                'start_time'     => '06:00',
                'end_time'       => '23:00',
                'price_per_hour' => 200000,
                'rule_type'      => 'weekend',
                'priority'       => 4,
            ]);
        }
    }
}