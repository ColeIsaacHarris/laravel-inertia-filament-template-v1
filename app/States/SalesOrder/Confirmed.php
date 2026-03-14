<?php

namespace App\States\SalesOrder;

class Confirmed extends SalesOrderState
{
    public static string $name = 'confirmed';

    public function label(): string
    {
        return 'Confirmed';
    }
}
