<?php

namespace Tests\Feature;

use App\Models\GiftCode;
use App\Models\GiftCodeUsage;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GiftCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_many_transactions()
    {
        $giftCode = GiftCode::factory()->create();
        Transaction::factory()->create(['gift_code_id' => $giftCode->id]);
        Transaction::factory()->create(['gift_code_id' => $giftCode->id]);

        $this->assertInstanceOf(Transaction::class, $giftCode->transactions->first());
        $this->assertCount(2, $giftCode->transactions);
    }

    public function test_it_has_many_gift_code_usages()
    {
        $giftCode = GiftCode::factory()->create();
        GiftCodeUsage::factory()->create(['gift_code_id' => $giftCode->id]);
        GiftCodeUsage::factory()->create(['gift_code_id' => $giftCode->id]);

        $this->assertInstanceOf(GiftCodeUsage::class, $giftCode->giftCodeUsages->first());
        $this->assertCount(2, $giftCode->giftCodeUsages);
    }

    public function test_it_can_be_created_with_factory()
    {
        $giftCode = GiftCode::factory()->create();

        $this->assertNotNull($giftCode);
    }
}
