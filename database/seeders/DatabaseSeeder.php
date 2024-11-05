<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $doctorNames = [
            'Dr. Julie Batol',
            'Dr. Jean Philippe Chabanne',
            'Dr. Philippe Fontaumard',
            'Dr. Amaury BROUSSE',
        ];

        foreach ($doctorNames as $name) {
            Doctor::create(['name' => $name]);
        }
    }
}
