<?php

namespace App\Modules\Shared\Enums;

enum WalletTransactionType: string
{
    case Deposit = 'deposit';
    case Withdrawal = 'withdrawal';
    case Withdrawal_Cancelled = 'withdrawal_cancelled';
    case Withdrawal_Rejected = 'withdrawal_rejected';
    case Payment = 'payment';
    case Manual = 'manual';
}
