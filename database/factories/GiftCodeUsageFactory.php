<?php

namespace Database\Factories;

use App\Models\GiftCode;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GiftCodeUsage>
 */
class GiftCodeUsageFactory extends Factory
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
            'user_id' => User::factory(),
            'wallet_id' => Wallet::factory(),
            'gift_code_id' => GiftCode::factory(),
        ];
    }
}
