<?php

namespace App\States\Invoice;

class Voided extends InvoiceState
{
    public static string $name = 'voided';

    public function label(): string
    {
        return 'Voided';
    }
}
