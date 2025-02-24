<?php

namespace Database\Seeders;

use App\Models\Guardhouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuardhouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Guardhouse::create([
            'name' => 'Guarita Laranjão',
            'campus_id' => 1,
        ]);

        Guardhouse::create([
            'name' => 'Guarita BMT 2',
            'campus_id' => 1,
        ]);

        Guardhouse::create([
            'name' => 'Guarita Rondon',
            'campus_id' => 2,
        ]);
    }
}
