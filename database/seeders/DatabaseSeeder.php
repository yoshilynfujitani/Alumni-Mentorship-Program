<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            User::factory()->create([
                'name' => 'User ' . ($i + 1),
                'email' => 'user' . ($i + 1) . '@example.com',
                'password' => Hash::make('12345678'),
                'role' => rand(1, 2), // 1 for student, 2 for mentor
                'course' => rand(1, 10),
                'field' => null,
                'verified' => 0,
                'first_login' => 1,
                'rating' => 0,
                'ticketStatus' => null,
                'fieldToTake' => null,
                'allowToAppoint' => 0,
               
            ]);
        }

        // Create the specific user with role 3
        User::factory()->create([
            'name' => 'Yoshi Admin',
            'email' => 'yoshi@admin.com',
            'password' => Hash::make('12345678'),
            'role' => 3,
            'course' => null,
            'field' => null,
            'verified' => 0,
            'first_login' => 1,
            'rating' => 0,
            'ticketStatus' => null,
            'fieldToTake' => null,
            'allowToAppoint' => 0,
            
        ]);
    }
}
