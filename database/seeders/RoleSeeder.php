<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


class RoleSeeder extends Seeder
{
    public function run(): void
<<<<<<< HEAD
    {
        // Membuat Role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $tpkRole = Role::firstOrCreate(['name' => 'TPK']);
    
        // Membuat Admin dengan NIK dan email
        $admin = User::firstOrCreate(
            ['NIK' => '1234567890123456'],  // Admin NIK
            [
                'name' => 'Admin', 
                'email' => 'admin@example.com',  // Tambahkan email
                'password' => bcrypt('password')
            ]
        );
        $admin->assignRole($adminRole);
    
        // Membuat TPK dengan NIK dan email
        $tpk = User::firstOrCreate(
            ['NIK' => '9876543210987654'],  // TPK NIK
            [
                'name' => 'TPK', 
                'email' => 'tpk@example.com',  // Tambahkan email
                'password' => bcrypt('password')
            ]
        );
        $tpk->assignRole($tpkRole);
    }
}
=======
{
    // Buat role
    $adminRole = Role::firstOrCreate(['name' => 'admin']);
    $tpkRole = Role::firstOrCreate(['name' => 'TPK']);

    // Tambahkan data manajemens (agar tidak error FK)
    DB::table('manajemens')->insertOrIgnore([
        [
            'NIK' => '1234567890123456',
            'nama' => 'Admin',
            'kecamatan' => 'Contoh Kecamatan',
            'kelurahan' => 'Contoh Kelurahan',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'NIK' => '9876543210987654',
            'nama' => 'TPK',
            'kecamatan' => 'Contoh Kecamatan',
            'kelurahan' => 'Contoh Kelurahan',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    // Buat user dan assign role
    $admin = User::firstOrCreate(
        ['NIK' => '1234567890123456'],
        [
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]
    );
    $admin->assignRole($adminRole);

    $tpk = User::firstOrCreate(
        ['NIK' => '9876543210987654'],
        [
            'name' => 'TPK',
            'email' => 'tpk@example.com',
            'password' => bcrypt('password')
        ]
    );
    $tpk->assignRole($tpkRole);
}
}
>>>>>>> f8229fd0ccc0906669accab8c056dbe0625f7e5d
