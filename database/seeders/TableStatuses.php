<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableStatuses extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tableStatuses = [
            ['slug' => 'available', 'label' => 'Disponível', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'reserved', 'label' => 'Reservada', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'inactive', 'label' => 'Inativa', 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('table_statuses')->insert($tableStatuses);
    }
}
