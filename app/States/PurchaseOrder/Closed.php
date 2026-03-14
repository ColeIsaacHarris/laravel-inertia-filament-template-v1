<?php

namespace App\States\PurchaseOrder;

class Closed extends PurchaseOrderState
{
    public static string $name = 'closed';

    public function label(): string
    {
        return 'Closed';
    }
}
