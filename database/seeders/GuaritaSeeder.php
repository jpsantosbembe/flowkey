<?php

namespace Database\Seeders;

use App\Models\Guarita;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuaritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Guarita::create([
            'nome' => 'Guarita 1',
            'campi_id' => 1,
        ]);

        Guarita::create([
            'nome' => 'Guarita 2',
            'campi_id' => 1,
        ]);

        Guarita::create([
            'nome' => 'Guarita 3',
            'campi_id' => 2,
        ]);
    }
}
