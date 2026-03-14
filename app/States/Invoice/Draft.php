<?php

namespace App\States\Invoice;

class Draft extends InvoiceState
{
    public static string $name = 'draft';

    public function label(): string
    {
        return 'Draft';
    }
}
