<?php

namespace Database\Seeders;

use App\Models\UniversityUsers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UniversityUsers::factory()->count(2)->create();

        // Manually insert admin users
        UniversityUsers::create([
            'user_role' => 'admin',
            'user_name' => 'Joseph',
            'full_name' => 'Joseph Sameh Fouad',
            'phone' => '01118295474',
            'whatsup_number' => '+201118295474',
            'address' => 'Admin Address 1',
            'password' => bcrypt('123456789'), // hashed password
            'email' => 'joseph.sameh.fouad@gmail.com',
            'student_img' => 'avatar.jpg',
        ]);

        UniversityUsers::create([
            'user_role' => 'admin',
            'user_name' => 'Jonathan',
            'full_name' => 'Jonathan',
            'phone' => '01203644940',
            'whatsup_number' => '+201203644940',
            'address' => 'Admin Address 2',
            'password' => bcrypt('Jonathan 123'), // hashed password
            'email' => '20220100@stud.fci-cu.edu.eg',
            'student_img' => 'avatar.jpg',
        ]);
        // Add more admin users as needed

    }
}
