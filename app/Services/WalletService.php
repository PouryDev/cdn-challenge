<?php

namespace App\Services;

use App\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class WalletService
{
    /**
     * Stores a new wallet record in DB
     *
     * @param string $userID
     * @return Wallet|null
     */
    public static function create(string $userID): ?Wallet
    {
        try {
            return Wallet::create([
                'id' => Uuid::uuid4()->toString(),
                'user_id' => $userID,
            ]);
        } catch (Exception $e) {
            Log::error($e);
            return null;
        }
    }

    /**
     * Increases the balance of given wallet
     *
     * @param Wallet|string $wallet
     * @param int $amount
     * @return bool
     */
    public static function increaseBalance(Wallet|string $wallet, int $amount): bool
    {
        if (is_string($wallet)) {
            $wallet = Wallet::find($wallet);
        }

        $wallet->balance += $amount;
        try {
            return $wallet->save();
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
    }
}
