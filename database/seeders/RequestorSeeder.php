<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RequestorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
          $Week = [
           'Student',
           'Employee',
         
        ];

        foreach ($Week as $Day) {
            DB::connection('mentor')->table('requestordetails')->insert([
                'requestor' => $Day,
         
            ]);
        }
    }
}
