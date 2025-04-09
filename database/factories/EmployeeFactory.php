<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'contract_start' => $this->faker->date(),
            'position_id' => null,
            'pis' => $this->faker->numberBetween(100000000000, 999999999999),
            'cpf' => $this->faker->numberBetween(10000000000, 99999999999),
            'rg' => $this->faker->numberBetween(100000000, 999999999),
            'rg_emission' => $this->faker->date(),
            'cep' => $this->faker->postcode(),
            'address' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'complement' => null,
            'neighborhood' => $this->faker->citySuffix(),
            'email' => $this->faker->email,
            'phone' => $this->faker->unique()->numerify('##########'),
            'spouse' => $this->faker->name(),
        ];
    }
}
