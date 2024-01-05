<?php

namespace Tests\Feature;

use App\Models\GiftCode;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_user()
    {
        $user = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $transaction->user);
        $this->assertEquals($user->id, $transaction->user->id);
    }

    public function test_it_belongs_to_wallet()
    {
        $wallet = Wallet::factory()->create();
        $transaction = Transaction::factory()->create(['wallet_id' => $wallet->id]);

        $this->assertInstanceOf(Wallet::class, $transaction->wallet);
        $this->assertEquals($wallet->id, $transaction->wallet->id);
    }

    public function test_it_belongs_to_gift_code()
    {
        $giftCode = GiftCode::factory()->create();
        $transaction = Transaction::factory()->create(['gift_code_id' => $giftCode->id]);

        $this->assertInstanceOf(GiftCode::class, $transaction->giftCode);
        $this->assertEquals($giftCode->id, $transaction->giftCode->id);
    }

    public function test_it_can_be_created_with_factory()
    {
        $transaction = Transaction::factory()->create();

        $this->assertNotNull($transaction);
    }
}
