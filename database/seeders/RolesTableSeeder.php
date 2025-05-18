<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'admin',  'description' => 'Administrador do sistema', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'client', 'description' => 'Cliente padrão',            'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
