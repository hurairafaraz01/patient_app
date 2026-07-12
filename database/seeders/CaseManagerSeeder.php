<?php

namespace Database\Seeders;
use App\Models\CaseManager;
use Illuminate\Database\Seeder;

class CaseManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      for ($i = 0; $i < 10; $i++) {
            CaseManager::create(['name' => fake()->name()]);
        }

    }
}
