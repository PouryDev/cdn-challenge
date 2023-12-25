<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    const TYPES = [
        'admin' => 'admin',
        'gift' => 'gift',
        'user' => 'user',
    ];
    const STATUSES = [
        'pending' => 'pending',
        'failed' => 'failed',
        'success' => 'success',
    ];

    /**
     * User who owns this transaction
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The affected wallet from this transaction
     *
     * @return BelongsTo
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * The gift code which used for this transaction
     *
     * @return BelongsTo
     */
    public function giftCode(): BelongsTo
    {
        return $this->belongsTo(GiftCode::class);
    }
}
