<?php

namespace App\States\PurchaseOrder;

class Confirmed extends PurchaseOrderState
{
    public static string $name = 'confirmed';

    public function label(): string
    {
        return 'Confirmed';
    }
}
