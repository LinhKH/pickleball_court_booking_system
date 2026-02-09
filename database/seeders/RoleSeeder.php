<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
  public function run(): void
  {
    foreach (['admin', 'owner', 'player', 'staff'] as $role) {
      Role::firstOrCreate(['name' => $role]);
    }
  }
}
