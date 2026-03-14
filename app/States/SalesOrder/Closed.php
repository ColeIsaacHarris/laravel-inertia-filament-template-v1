<?php

namespace App\States\SalesOrder;

class Closed extends SalesOrderState
{
    public static string $name = 'closed';

    public function label(): string
    {
        return 'Closed';
    }
}
