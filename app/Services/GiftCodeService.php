<?php

namespace App\Services;

use App\Models\GiftCode;
use App\Models\GiftCodeUsage;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class GiftCodeService
{
    /**
     * Stores new gift code in DB
     *
     * @param int $amount
     * @param string $code
     * @param int $maxUsage
     * @param Carbon|null $expireAt
     * @return GiftCode|null
     */
    public static function create(int $amount, string $code, int $maxUsage, Carbon $expireAt = null): ?GiftCode
    {
        try {
            return GiftCode::create([
                'id' => Uuid::uuid4()->toString(),
                'amount' => $amount,
                'code' => $code,
                'max_usage' => $maxUsage,
                'expire_at' => $expireAt,
            ]);
        } catch (Exception $e) {
            Log::error($e);
            return null;
        }
    }

    /**
     * Checks if user can use the gift code
     *
     * @param string|GiftCode $code
     * @param string $userID
     * @return bool
     */
    public static function isValid(string|GiftCode $code, int $userID): bool
    {
        if (is_string($code)) {
            $code = GiftCode::find($code);
        }

        if ($code->used_count >= $code->max_usage) {
            return false;
        }

        if ($code->expire_at?->isPast()) {
            return false;
        }

        $usedBefore = GiftCodeUsage::where('user_id', $userID)
            ->where('gift_code_id', $code->id)
            ->exists();
        if ($usedBefore) {
            return false;
        }

        return true;
    }

    /**
     * Uses the given gift code
     *
     * @param GiftCode $code
     * @param User $user
     * @return null|int
     */
    public static function use(GiftCode $code, User $user): ?int
    {
        try {
            $usedCount = $code->increment('used_count');

            $usage = GiftCodeUsage::create([
                'id' => Uuid::uuid4()->toString(),
                'gift_code_id' => $code->id,
                'user_id' => $user->id,
                'wallet_id' => $user->wallet->id,
            ]);

            if (empty($usage)) {
                return null;
            }
            return $usedCount;
        } catch (Exception $e) {
            Log::error($e);
            return null;
        }
    }
}
