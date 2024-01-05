<?php

namespace Tests\Feature;

use App\Models\GiftCodeUsage;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_user()
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $wallet->user);
        $this->assertEquals($user->id, $wallet->user->id);
    }

    public function test_it_has_many_transactions()
    {
        $wallet = Wallet::factory()->create();Transaction::factory()->create(['wallet_id' => $wallet->id]);
        Transaction::factory()->create(['wallet_id' => $wallet->id]);

        $this->assertInstanceOf(Transaction::class, $wallet->transactions->first());
        $this->assertCount(2, $wallet->transactions);
    }

    public function test_it_has_many_gift_code_usages()
    {
        $wallet = Wallet::factory()->create();
        GiftCodeUsage::factory()->create(['wallet_id' => $wallet->id]);
        GiftCodeUsage::factory()->create(['wallet_id' => $wallet->id]);

        $this->assertInstanceOf(GiftCodeUsage::class, $wallet->giftCodeUsages->first());
        $this->assertCount(2, $wallet->giftCodeUsages);
    }

    public function test_it_can_be_created_with_factory()
    {
        $wallet = Wallet::factory()->create();

        $this->assertNotNull($wallet);
    }
}
