<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'name'         => 'Super Admin',
            'email'        => 'superadmin@radio.com',
            'phone'        => '000000000',
            'password'     => Hash::make('123456'),
            'user_role_id' => 1,
        ]);
        User::create([
            'name'         => 'Demo Admin',
            'email'        => 'demoadmin@radio.com',
            'phone'        => '000000000',
            'password'     => Hash::make('123456'),
            'user_role_id' => 1,
        ]);
    }
}
