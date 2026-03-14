<?php

namespace App\States\SalesOrder;

class PartiallyShipped extends SalesOrderState
{
    public static string $name = 'partially_shipped';

    public function label(): string
    {
        return 'Partially Shipped';
    }
}
