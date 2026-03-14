<?php

namespace App\States\SalesOrder;

class Invoiced extends SalesOrderState
{
    public static string $name = 'invoiced';

    public function label(): string
    {
        return 'Invoiced';
    }
}
