<?php

namespace App\Modules\Shared\Enums;

use Illuminate\Contracts\Support\DeferringDisplayableValue;

enum WithdrawalType: string implements DeferringDisplayableValue
{
    case Cash = 'cash';
    case BankTransaction = 'bank_transaction';
    case Gcash = 'gcash';
    case Maya = 'maya';

    public function resolveDisplayableValue()
    {
        return match ($this) {
            self::Cash => __('Cash'),
            self::BankTransaction => __('Bank Transaction'),
            self::Gcash => __('G-Cash'),
            self::Maya => __('Maya'),
        };
    }
}
