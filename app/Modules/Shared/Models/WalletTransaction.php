<?php

namespace App\Modules\Shared\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * App\Modules\Shared\Models\WalletTransaction
 *
 * @property int $id
 * @property int $wallet_id
 * @property int $amount
 * @property int $transactionable_id
 * @property string $transactionable_type
 * @property string $reference_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction whereTransactionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction whereTransactionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction whereWalletId($value)
 * @property int $wallet_transaction_id
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction whereWalletTransactionId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperWalletTransaction
 */
class WalletTransaction extends Model
{
    use HasFactory;

    const CACHE_KEY = 'wallet_transaction_';

    protected $primaryKey = 'wallet_transaction_id';

    protected $guarded = [];

    protected static function booted()
    {
        static::updated(function ($model) {
            Cache::forget(self::CACHE_KEY.$model->wallet_transaction_id);
        });
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_numeric($value) ? $value / 100 : $value,
        );
    }
}
