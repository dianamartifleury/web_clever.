<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermanentUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin1234'), // cambia esto por una contraseña segura
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Tester
        DB::table('users')->updateOrInsert(
            ['email' => 'testin@example.com'],
            [
                'name' => 'Tester',
                'password' => Hash::make('testin1234'), // cambia esto también
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
