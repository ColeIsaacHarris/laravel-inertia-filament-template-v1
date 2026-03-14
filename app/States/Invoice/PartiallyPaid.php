<?php

namespace App\States\Invoice;

class PartiallyPaid extends InvoiceState
{
    public static string $name = 'partially_paid';

    public function label(): string
    {
        return 'Partially Paid';
    }
}
