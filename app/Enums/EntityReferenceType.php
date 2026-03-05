<?php

namespace App\Enums;

enum EntityReferenceType: string
{
    case SLAB = 'slab';
    case HOLD = 'hold';
    case ORDER = 'order';
    case INVOICE = 'invoice';
    case QUOTE = 'quote';
    case DELIVERY_REQUEST = 'delivery_request';
}
