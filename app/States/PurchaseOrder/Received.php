<?php

namespace App\States\PurchaseOrder;

class Received extends PurchaseOrderState
{
    public static string $name = 'received';

    public function label(): string
    {
        return 'Received';
    }
}
