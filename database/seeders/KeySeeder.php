<?php

namespace Database\Seeders;

use App\Models\Key;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Key::create([
            'label' => 'Key 1',
            'description' => 'Key 1 description',
            'guardhouse_id' => 1,
        ]);
        Key::create([
            'label' => 'Key 2',
            'description' => 'Key 2 description',
            'guardhouse_id' => 1,
        ]);
        Key::create([
            'label' => 'Key 3',
            'description' => 'Key 3 description',
            'guardhouse_id' => 2,
        ]);
    }
}
