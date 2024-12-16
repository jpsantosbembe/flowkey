<?php

namespace Database\Seeders;

use App\Models\KeyAuthorization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeyAuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        KeyAuthorization::create([
            'key_id' => 1,
            'user_id' => 1,
            'is_active' => true,
        ]);

        KeyAuthorization::create([
            'key_id' => 2,
            'user_id' => 2,
            'is_active' => true,
        ]);

        KeyAuthorization::create([
            'key_id' => 3,
            'user_id' => 3,
            'is_active' => true,
        ]);
    }
}
