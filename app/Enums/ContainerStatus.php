<?php

namespace App\Enums;

enum ContainerStatus: string
{
    case BOOKED = 'booked';
    case LOADED = 'loaded';
    case IN_TRANSIT = 'in_transit';
    case ARRIVED_AT_PORT = 'arrived_at_port';
    case CUSTOMS_HOLD = 'customs_hold';
    case CUSTOMS_CLEARED = 'customs_cleared';
    case IN_TRANSIT_DOMESTIC = 'in_transit_domestic';
    case DELIVERED = 'delivered';
    case RECEIVED = 'received';
}
