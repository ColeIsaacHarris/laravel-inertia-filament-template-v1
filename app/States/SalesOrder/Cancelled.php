<?php

namespace App\States\SalesOrder;

class Cancelled extends SalesOrderState
{
    public static string $name = 'cancelled';

    public function label(): string
    {
        return 'Cancelled';
    }
}
