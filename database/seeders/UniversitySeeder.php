<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        University::factory()->count(2)->create();

        // Manually insert admin users
        University::create([
            'user_role' => 'admin',
            'user_name' => 'Joseph',
            'full_name' => 'Joseph Sameh Fouad',
            'phone' => '+201118295474',
            'whatsup_number' => '+201118295474',
            'address' => 'Admin Address 1',
            'password' => bcrypt('123456789'), // hashed password
            'email' => 'joseph.sameh.fouad@gmail.com',
            'student_img' => 'avatar.jpg',
        ]);
        // Add more admin users as needed

    }
}
