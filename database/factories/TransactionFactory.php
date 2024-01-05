<?php

namespace Database\Factories;

use App\Models\GiftCode;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Uuid::uuid4()->toString(),
            'gift_code_id' => GiftCode::factory(),
            'amount' => fake()->randomFloat(0, 100000, 1000000),
            'user_id' => User::factory(),
            'type' => fake()->randomElement(Transaction::TYPES),
            'status' => fake()->randomElement(Transaction::STATUSES),
            'wallet_id' => Wallet::factory(),
        ];
    }
}
