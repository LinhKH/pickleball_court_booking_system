<?php
namespace Database\Seeders;
use App\Models\Court;
use Illuminate\Database\Seeder;

class CourtSeeder extends Seeder
{
    public function run(): void
    {
        Court::firstOrCreate(
            ['name' => 'Pickleball Court A'],
            [
                'owner_id'   => 1,
                'description'=> 'Sân pickleball tiêu chuẩn thi đấu',
                'address'    => 'Quận 7, TP.HCM',
                'lat'        => 10.7296,
                'lng'        => 106.7210,
                'open_time'  => '06:00',
                'close_time' => '23:00',
                'status'     => 'active',
            ]
        );
    }
}