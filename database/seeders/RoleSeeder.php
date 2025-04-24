<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Membuat Role
        $ra = Role::firstOrCreate(['name' => 'admin']);
        $rop = Role::firstOrCreate(['name'=> 'TPK']);

        $user2 = User::factory()->create([
            'email' => 'admin@gmail.com',
            'name' => 'Admin',
        ]);
        $user2->assignRole($ra);

        $user3 = User::factory()->create([
            'name' => 'TPK',
            'email' => 'TPK@gmail.com',
        ]);
        $user3->assignRole($rop);
    }
}
