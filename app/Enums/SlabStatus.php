<?php

namespace App\Enums;

enum SlabStatus: string
{
    case IN_TRANSIT = 'in_transit';
    case AVAILABLE = 'available';
    case ON_HOLD = 'on_hold';
    case RESERVED = 'reserved';
    case SOLD = 'sold';
    case CUT_CONSUMED = 'cut-consumed';
    case RETURNED = 'returned';
    case DAMAGED = 'damaged';
    case CONSIGNED = 'consigned';
}
