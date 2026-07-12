<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
        'first_name' => 'huraira',
        'middle_name' => null,
        'last_name' => 'faraz',
        'email' => 'huraira.faraz@ovadadme.com',
        'password' => Hash::make('Huraira@123'),
    ]);
    }
}
