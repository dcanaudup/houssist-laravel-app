<?php

namespace App\Modules\HomeOwner\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case WALLET = 'wallet';
    case BANK_TRANSACTION = 'bank_transaction';
    case GCASH = 'gcash';
    case MAYA = 'maya';
}
