<?php

namespace App\Enums;

enum PricingScope: string
{
    case CUSTOMER = 'customer';
    case TIER = 'tier';
    case VOLUME = 'volume';
    case PROMOTIONAL = 'promotional';
    case LIST = 'list';
}
