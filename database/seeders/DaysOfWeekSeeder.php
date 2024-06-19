<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DaysOfWeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $Week = [
           'Sunday',
           'Monday',
           'Tuesday',
           'Wednesday',
           'Thursday',
           'Friday', 
           'Saturday'
        ];

        foreach ($Week as $Day) {
            DB::connection('mentor')->table('daysoftheweek')->insert([
                'dayName' => $Day,
         
            ]);
        }
    }
}
