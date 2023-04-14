<?php

namespace App\Models;

use App\Modules\Shared\Enums\WithdrawalStatus;
use App\Modules\Shared\Enums\WithdrawalType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Shared\Models\User;
/**
 * @mixin IdeHelperWithdrawal
 */
class Withdrawal extends Model
{
    public const CACHE_KEY = 'withdrawal_';

    use HasFactory;

    protected $primaryKey = 'withdrawal_id';

    protected $guarded = [];

    protected $casts = [
        'withdrawal_type' => WithdrawalType::class,
        'status' => WithdrawalStatus::class,
        'latest_transaction_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
