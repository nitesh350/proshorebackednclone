<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Cesar Morales',
            'email' => 'cesar@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin'
        ]);
    }
}
