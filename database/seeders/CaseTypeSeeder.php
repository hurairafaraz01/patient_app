<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CaseType;

class CaseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'No Fault',
            'WC',
            'Private',
            'Lien',
            'BTC',
            'Commercial',
        ];

        foreach ($types as $type) {
            CaseType::updateOrCreate(
                ['name' => $type]
            );
        }
    }
}
