<?php

namespace Database\Seeders;

use App\Models\Campi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Campi::create(['nome' => 'Campus Tapajos']);
        Campi::create(['nome' => 'Campus Rondon']);
    }
}
