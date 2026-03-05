<?php

namespace App\Enums;

enum DimensionStage: string
{
    case PURCHASED = 'purchased';
    case RECEIVED = 'received';
    case SOLD = 'sold';
    case RETURNED = 'returned';
}
