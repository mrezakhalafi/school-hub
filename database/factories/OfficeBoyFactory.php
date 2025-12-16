<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OfficeBoy>
 */
class OfficeBoyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'birth_date' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'address' => $this->faker->address,
            'employee_id' => 'OB' . $this->faker->unique()->numberBetween(10000, 99999),
            'department' => $this->faker->randomElement(['cleaning', 'maintenance', 'reception', 'general services', 'security']),
            'hire_date' => $this->faker->date(),
        ];
    }
}
