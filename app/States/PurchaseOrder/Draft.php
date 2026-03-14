<?php

namespace App\States\PurchaseOrder;

class Draft extends PurchaseOrderState
{
    public static string $name = 'draft';

    public function label(): string
    {
        return 'Draft';
    }
}
