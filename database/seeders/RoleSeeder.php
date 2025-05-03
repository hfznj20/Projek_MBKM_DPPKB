<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
