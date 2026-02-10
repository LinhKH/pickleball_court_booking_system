<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  public function run(): void
  {
    $owner = User::firstOrCreate(
      ['email' => 'owner@pickleball.test'],
      [
        'name' => 'Court Owner',
        'password' => Hash::make('password'),
      ]
    );

    $player = User::firstOrCreate(
      ['email' => 'player@pickleball.test'],
      [
        'name' => 'Player One',
        'password' => Hash::make('password'),
      ]
    );

    $owner->roles()->syncWithoutDetaching([1]); // owner
    $player->roles()->syncWithoutDetaching([2]); // player
  }
}
