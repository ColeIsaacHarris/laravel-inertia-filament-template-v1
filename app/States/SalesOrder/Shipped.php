<?php

namespace App\States\SalesOrder;

class Shipped extends SalesOrderState
{
    public static string $name = 'shipped';

    public function label(): string
    {
        return 'Shipped';
    }
}
