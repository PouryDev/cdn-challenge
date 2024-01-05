<?php

namespace App\Services;

use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class TransactionService
{
    /**
     * Store new transaction in DB
     *
     * @param int $amount
     * @param int $userID
     * @param string $type
     * @param string $walletID
     * @param string|null $giftID
     * @param string|null $status
     * @return Transaction|null
     */
    public static function create(
        int $amount,
        int $userID,
        string $type,
        string $walletID,
        string $giftID = null,
        string $status = null,
    ): ?Transaction
    {
        try {
            return Transaction::create([
                'id' => Uuid::uuid4()->toString(),
                'amount' => $amount,
                'user_id' => $userID,
                'type' => $type,
                'wallet_id' => $walletID,
                'gift_code_id' => $giftID,
                'status' => $status ?? Transaction::STATUSES['pending'],
            ]);
        } catch (Exception $e) {
            Log::error($e);
            return null;
        }
    }

    /**
     * Change status of the given transaction instance
     *
     * @param Transaction $transaction
     * @param string $status
     * @return bool
     */
    public static function changeStatus(Transaction $transaction, string $status): bool
    {
        $transaction->status = $status;
        try {
            return $transaction->save();
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
    }
}
