<?php

namespace App\Enums;

enum DeliveryRequestStatus: string
{
    case REQUESTED = 'requested';
    case CONFIRMED = 'confirmed';
    case ALTERNATIVE_PROPOSED = 'alternative_proposed';
    case DECLINED = 'declined';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
}
