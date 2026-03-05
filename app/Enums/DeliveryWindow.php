<?php

namespace App\Enums;

enum DeliveryWindow: string
{
    case MORNING = 'morning';
    case AFTERNOON = 'afternoon';
    case FULL_DAY = 'full_day';
}
