<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationStatuses extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reservationStatuses = [
            ['slug' => 'active', 'label' => 'Ativo', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'cancelled', 'label' => 'Cancelado', 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'pending', 'label' => 'Pendente', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('reservation_statuses')->insert($reservationStatuses);
    }
}
