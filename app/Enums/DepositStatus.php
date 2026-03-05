<?php

namespace App\Enums;

enum DepositStatus: string
{
    case PENDING = 'pending';
    case RECEIVED = 'received';
    case REFUNDED = 'refunded';
    case APPLIED = 'applied';
}
