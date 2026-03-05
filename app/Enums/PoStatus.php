<?php

namespace App\Enums;

enum PoStatus: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case CONFIRMED = 'confirmed';
    case PARTIALLY_RECEIVED = 'partially_received';
    case RECEIVED = 'received';
    case CLOSED = 'closed';
    case CANCELLED = 'cancelled';
}
