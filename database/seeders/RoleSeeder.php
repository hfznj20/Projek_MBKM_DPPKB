<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TPK;
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
        $tpkRole   = Role::firstOrCreate(['name'=> 'TPK']);

        // Membuat User Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );
        $admin->assignRole($adminRole);

        // Membuat User TPK
        $tpk = User::firstOrCreate(
            ['email' => 'TPK@gmail.com'],
            [
                'name' => 'TPK',
                'password' => bcrypt('password'),
            ]
        );
        $tpk->assignRole($tpkRole);

        // Membuat User Muhammad Ikhlashul Amal
        $amal = User::firstOrCreate(
            ['email' => 'ikhlashulamal@gmail.com'],
            [
                'name' => 'Muhammad Ikhlashul Amal',
                'password' => bcrypt('opalepale'),
            ]
        );
        $amal->assignRole($adminRole);
    }
}
