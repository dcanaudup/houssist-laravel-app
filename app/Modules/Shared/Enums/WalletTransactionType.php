<?php

namespace App\Modules\Shared\Enums;

enum WalletTransactionType: string
{
    case Deposit = 'deposit';
    case Withdrawal = 'withdrawal';
    case Payment = 'payment';
}
