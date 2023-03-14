<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin role'
        ]);

        Role::create([
            'name' => 'vendor role'
        ]);

        Role::create([
            'name' => 'user role'
        ]);
    }
}
