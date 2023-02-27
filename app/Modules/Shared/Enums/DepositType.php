<?php

namespace App\Modules\Shared\Enums;

enum DepositType: string
{
    case Cash = 'cash';
    case BankTransaction = 'bank_transaction';
    case Gcash = 'gcash';
    case Maya = 'maya';
}
