<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $incrementing = false;

    /**
     * The user related to the wallet
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * This wallet's transactions collection
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * A collection of gift codes charged this wallet
     *
     * @return HasMany
     */
    public function giftCodeUsages(): HasMany
    {
        return $this->hasMany(GiftCodeUsage::class);
    }
}
