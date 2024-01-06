<?php

namespace App\Services;

use App\Models\GiftCode;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UseGiftCode
{
    public static function handle(GiftCode $code, User $user): JsonResponse
    {
        if (!GiftCodeService::isValid($code, $user->id)) {
            return response()->json(['message' => 'You cannot use this code']);
        }

        DB::beginTransaction();

        $usedCount = GiftCodeService::use($code, $user);
        if (is_null($usedCount)) {
            return self::onFail('Something went wrong on using gift code');
        }

        if ($usedCount > $code->max_usage) {
            return self::onFail('Code limit has been reached');
        }

        $wallet = $user->wallet()->first();
        $amount = $code->amount;

        $transaction = TransactionService::create(
            $amount,
            $user->id,
            Transaction::TYPES['gift'],
            $wallet->id,
            $code->id,
        );
        if (is_null($transaction)) {
            return self::onFail('Failed to create transaction');
        }

        $flag = WalletService::increaseBalance($wallet, $amount);
        if (!$flag) {
            return self::onFail('Something went wrong on increasing wallet balance');
        }

        $flag = TransactionService::changeStatus($transaction, Transaction::STATUSES['success']);
        if (!$flag) {
            return self::onFail('Something went wrong on changing transaction status');
        }

        DB::commit();

        return response()->json(['message' => 'Gift code used successfully']);
    }

    private static function onFail(string $message): JsonResponse
    {
        DB::rollBack();
        return response()->json([
            'message' => $message,
        ], 500);
    }
}
