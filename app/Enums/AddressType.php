<?php

namespace App\Enums;

enum AddressType: string
{
    case BILLING = 'billing';
    case SHIPPING = 'shipping';
    case WAREHOUSE = 'warehouse';
    case FACTORY = 'factory';
    case PORT = 'port';
    case OFFICE = 'office';
    case SHOWROOM = 'showroom';
}
