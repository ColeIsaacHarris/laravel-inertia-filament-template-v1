<?php

namespace App\States\SalesOrder;

class Draft extends SalesOrderState
{
    public static string $name = 'draft';

    public function label(): string
    {
        return 'Draft';
    }
}
