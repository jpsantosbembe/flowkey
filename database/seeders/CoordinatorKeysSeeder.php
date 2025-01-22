<?php

namespace Database\Seeders;

use App\Models\CoordinatorsKeys;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoordinatorKeysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // IDs de usuários docentes (9 a 11)
        $docenteIds = [9, 10, 11];

        $keyIds = range(1, 3);

        // Cria associações na tabela `coordinators_keys`
        foreach ($docenteIds as $docenteId) {
            foreach ($keyIds as $keyId) {
                CoordinatorsKeys::updateOrCreate([
                    'user_id' => $docenteId,
                    'key_id' => $keyId,
                ]);
            }
        }
    }
}
