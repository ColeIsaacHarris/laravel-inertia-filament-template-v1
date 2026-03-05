<?php

namespace App\Enums;

enum CustomerTier: string
{
    case PLATINUM = 'platinum';
    case GOLD = 'gold';
    case SILVER = 'silver';
    case STANDARD = 'standard';
}
