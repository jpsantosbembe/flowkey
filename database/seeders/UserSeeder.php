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
            'name' => 'Rennan',
            'email' => 'rennan@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Vania',
            'email' => 'vania@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'João',
            'email' => 'joao@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Isaac',
            'email' => 'isaac@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Savio',
            'email' => 'savio@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Jardson',
            'email' => 'jardson@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Guarda 1',
            'email' => 'guarda1@example.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Guarda 2',
            'email' => 'guarda2@example.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
