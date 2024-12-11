<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'João Silva',
            'email' => 'joao.silva@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Maria Oliveira',
            'email' => 'maria.oliveira@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Carlos Pereira',
            'email' => 'carlos.pereira@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Ana Costa',
            'email' => 'ana.costa@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Lucas Santos',
            'email' => 'lucas.santos@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Beatriz Lima',
            'email' => 'beatriz.lima@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Felipe Souza',
            'email' => 'felipe.souza@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Camila Rocha',
            'email' => 'camila.rocha@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Pedro Almeida',
            'email' => 'pedro.almeida@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Juliana Ramos',
            'email' => 'juliana.ramos@example.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
