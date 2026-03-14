<?php

namespace App\States\PurchaseOrder;

class Cancelled extends PurchaseOrderState
{
    public static string $name = 'cancelled';

    public function label(): string
    {
        return 'Cancelled';
    }
}
