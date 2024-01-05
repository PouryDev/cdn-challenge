<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GiftCode extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $incrementing = false;


    /**
     * All transactions created by this gift code
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * A collection of the usages of this gift code
     *
     * @return HasMany
     */
    public function giftCodeUsages(): HasMany
    {
        return $this->hasMany(GiftCodeUsage::class);
    }
}
