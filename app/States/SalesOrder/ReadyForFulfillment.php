<?php

namespace App\States\SalesOrder;

class ReadyForFulfillment extends SalesOrderState
{
    public static string $name = 'ready_for_fulfillment';

    public function label(): string
    {
        return 'Ready for Fulfillment';
    }
}
