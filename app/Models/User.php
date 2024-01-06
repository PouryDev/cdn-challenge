<?php

namespace App\Models;

use App\Services\WalletService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['phone_number', 'email'];

    protected static function booted(): void
    {
        parent::booted();
        static::created(function (User $user) {
            WalletService::create($user->id);
        });
    }

    /**
     * This user's wallet
     *
     * @return HasOne
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * This user's transactions collection
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * A collection of gift codes this user used
     *
     * @return HasMany
     */
    public function giftCodeUsages(): HasMany
    {
        return $this->hasMany(GiftCodeUsage::class);
    }
}
