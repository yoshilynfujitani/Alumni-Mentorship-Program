<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AppointmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $statusNames = [
            ['name' => 'Pending', 'value' => 0],
            ['name' => 'Accepted', 'value' => 1],
            ['name' => 'Rejected', 'value' => 2],
            ['name' => 'Finished', 'value' => 3],
            ['name' => 'Cancelled', 'value' => 4],
        ];

        foreach ($statusNames as $status) {
            DB::connection('mentor')->table('appointmentstatus')->insert([
                'statusName' => $status['name'],
                'statusId' => $status['value'],
            ]);
        }
    }
}
