<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GiftCode>
 */
class GiftCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(0, 100000, 1000000),
            'id' => Uuid::uuid4()->toString(),
            'code' => Str::random(rand(4, 10)),
            'expire_at' => fake()->dateTimeBetween(now()->addDay(), now()->addYear()),
            'max_usage' => fake()->randomFloat(0, 10, 10000),
        ];
    }
}
