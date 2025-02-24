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
        Key::create([
            'label'         => 'Chave 37',
            'description'   => 'Laboratório de Algoritmos',
            'guardhouse_id' => 1,
        ]);

        Key::create([
            'label'         => 'Chave 221',
            'description'   => 'Laboratório de Inovação',
            'guardhouse_id' => 1,
        ]);

        Key::create([
            'label'         => 'Chave 145A',
            'description'   => 'Laboratorio do Rondon',
            'guardhouse_id' => 2,
        ]);
    }
}
