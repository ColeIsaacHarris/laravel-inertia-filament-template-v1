<?php

namespace App\Enums;

enum LocationType: string
{
    case WAREHOUSE = 'warehouse';
    case YARD = 'yard';
    case CONSIGNMENT = 'consignment';
    case IN_TRANSIT = 'in_transit';
}
