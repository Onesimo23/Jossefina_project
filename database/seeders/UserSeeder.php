<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar usuário Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Criar usuário Coordenador
        User::create([
            'name' => 'Coordenador Principal',
            'email' => 'coordenador@example.com',
            'password' => Hash::make('password'),
            'role' => 'coordinator',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Jossefina Sitoe',
            'email' => 'jossefina@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'coordinator',
            'email_verified_at' => now(),
        ]);

        // Usuários da comunidade
        User::create([
            'name' => 'Ana Costa',
            'email' => 'ana.costa@example.com',
            'password' => Hash::make('password'),
            'role' => 'community',
            'email_verified_at' => now(),
        ]);
    }
}
