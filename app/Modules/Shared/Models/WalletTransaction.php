<?php

namespace App\Modules\Shared\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $guarded = [];
}
