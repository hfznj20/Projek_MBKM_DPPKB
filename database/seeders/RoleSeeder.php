<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $tpkRole = Role::firstOrCreate(['name' => 'TPK']);

        // Buat user superadmin (tidak masuk ke tabel manajemens)
        $superadmin = User::firstOrCreate(
            ['NIK' => '0000000000000001'],
            [
                'name' => 'Superadmin',
                'email' => 'superadmin@example.com',
                'password' => bcrypt('superadmin123')
            ]
        );
        $superadmin->assignRole($superadminRole);

        // Tambahkan data manajemens (hanya untuk admin dan TPK)
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

        // Buat user admin dan TPK
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
