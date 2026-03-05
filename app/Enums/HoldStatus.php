<?php

namespace App\Enums;

enum HoldStatus: string
{
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case CONVERTED = 'converted';
    case RELEASED = 'released';
}
