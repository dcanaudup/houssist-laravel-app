<?php

namespace App\Modules\Shared\Enums;

enum WalletTransactionType: string
{
    case Deposit = 'deposit';
    case Withdrawal = 'withdrawal';
    case Withdrawal_Cancelled = 'withdrawal_cancelled';
    case Withdrawal_Rejected = 'withdrawal_rejected';
    case Payment = 'payment';
    case Ad_Cancelled = 'ad_cancelled';
    case Manual = 'manual';
    case Dispute_Refund = 'dispute_refund';
    case Dispute_Payment = 'dispute_payment';
}
