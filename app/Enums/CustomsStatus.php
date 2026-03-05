<?php

namespace App\Enums;

enum CustomsStatus: string
{
    case PENDING = 'pending';
    case CLEARED = 'cleared';
    case HELD = 'held';
    case RELEASED = 'released';
}
