<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CHECK = 'check';
    case WIRE = 'wire';
    case CREDIT_CARD = 'credit_card';
    case CASH = 'cash';
    case ACH = 'ach';
}
