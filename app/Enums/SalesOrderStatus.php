<?php

namespace App\Enums;

enum SalesOrderStatus: string
{
    case DRAFT = 'draft';
    case CONFIRMED = 'confirmed';
    case READY_FOR_FULFILLMENT = 'ready_for_fulfillment';
    case PARTIALLY_SHIPPED = 'partially_shipped';
    case SHIPPED = 'shipped';
    case INVOICED = 'invoiced';
    case CLOSED = 'closed';
    case CANCELLED = 'cancelled';
}
