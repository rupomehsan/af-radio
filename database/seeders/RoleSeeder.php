<?php
namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::truncate();
        UserRole::create(['name' => 'SuperAdmin', 'status' => 'active']);
        UserRole::create(['name' => 'Admin', 'status' => 'active']);
        UserRole::create(['name' => 'User', 'status' => 'active']);
    }
}