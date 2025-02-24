<?php

namespace Database\Seeders;

use App\Models\CoordinatorsKeys;
use Illuminate\Database\Seeder;

class CoordinatorKeysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        CoordinatorsKeys::create([
            'key_id'  => 1,
            'user_id' => 2,
        ]);

        CoordinatorsKeys::create([
            'key_id'  => 2,
            'user_id' => 3,
        ]);

    }
}
