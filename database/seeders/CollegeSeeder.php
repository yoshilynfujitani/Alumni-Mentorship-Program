<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
       $colleges = [
            'CCIS',
            'CHS',
            'CBEA',
            'COE',
            'CAS',
            'COM',
            'CAFSD',
            'CASAT',
            'CIT',
            'CTE',
        ];

        foreach ($colleges as $college) {
            DB::connection('admin')->table('colleges')->insert([
                'CollegeName' => $college,
            ]);
        }
    }
}
