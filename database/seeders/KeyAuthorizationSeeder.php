<?php

namespace Database\Seeders;

use App\Models\KeyAuthorization;
use Illuminate\Database\Seeder;

class KeyAuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KeyAuthorization::create([
            'key_id'   => 1,
            'user_id'  => 4,
            'is_active'=> true,
        ]);

        KeyAuthorization::create([
            'key_id'   => 1,
            'user_id'  => 5,
            'is_active'=> true,
        ]);

        KeyAuthorization::create([
            'key_id'   => 2,
            'user_id'  => 4,
            'is_active'=> true,
        ]);

        KeyAuthorization::create([
            'key_id'   => 2,
            'user_id'  => 6,
            'is_active'=> true,
        ]);

        KeyAuthorization::create([
            'key_id'   => 2,
            'user_id'  => 7,
            'is_active'=> true,
        ]);
    }
}
