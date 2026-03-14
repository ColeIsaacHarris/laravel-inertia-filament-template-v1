<?php

namespace App\States\PurchaseOrder;

class Submitted extends PurchaseOrderState
{
    public static string $name = 'submitted';

    public function label(): string
    {
        return 'Submitted';
    }
}
