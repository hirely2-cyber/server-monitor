<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Roles menggunakan Spatie
        $roleSuperadmin = Role::create(['name' => 'Superadmin']);
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleUser = Role::create(['name' => 'User']);

        // 2. Buat Akun Utama (Superadmin)
        $superadmin = User::create([
            'name' => 'Super Administrator',
            'username' => 'superadmin',
            'email' => 'admin@monitor.com',
            'password' => Hash::make('password123'), // Password default: password123
            'email_verified_at' => now(),
        ]);

        // 3. Tempelkan Role Superadmin ke akun tersebut
        $superadmin->assignRole($roleSuperadmin);

        // 4. (Opsional) Buat Akun User Biasa untuk testing nanti
        $userBiasa = User::create([
            'name' => 'Pengguna Biasa',
            'username' => 'pengguna',
            'email' => 'user@monitor.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        
        $userBiasa->assignRole($roleUser);
    }
}