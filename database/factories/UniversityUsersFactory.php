<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UniversityUsers>
 */
class UniversityUsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_role' => 'user', // or randomElement(['user', 'admin']) if needed
            'user_name' => $this->faker->unique()->userName,
            'full_name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'whatsup_number' => '+20' . $this->faker->numerify('1#########'),
            'address' => $this->faker->address,
            'password' => bcrypt('password'), // hashed dummy password
            'email' => $this->faker->unique()->safeEmail,
            'student_img' => 'avatar.jpg', // or path to random image
        ];
    }
}
