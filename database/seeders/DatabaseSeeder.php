<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call other seeders first to ensure necessary data is available
        $this->call([
            AppointmentStatusSeeder::class,
            CollegeSeeder::class,
            DaysOfWeekSeeder::class,
            RequestorSeeder::class,
            UserStatusSeeder::class,
        ]);

        // Create 100 random users
        for ($i = 0; $i < 500; $i++) {
            User::factory()->create([
                'name' => 'User ' . ($i + 1),
                'email' => 'user' . ($i + 1) . '@example.com',
                'password' => Hash::make('12345678'),
                'role' => rand(1, 2), // 1 for student, 2 for mentor
                'course' => rand(1, 10), // Ensure this range matches your actual college IDs
                'field' => null,
                'verified' => rand(0,1),
                'first_login' => 1,
                'rating' => 0,
                'ticketStatus' => null,
                'fieldToTake' => null,
                'allowToAppoint' => 0,
                'last_active_at' => null,
                
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
