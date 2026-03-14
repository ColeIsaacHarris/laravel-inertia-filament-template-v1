<?php

namespace App\States\PurchaseOrder;

class PartiallyReceived extends PurchaseOrderState
{
    public static string $name = 'partially_received';

    public function label(): string
    {
        return 'Partially Received';
    }
}
