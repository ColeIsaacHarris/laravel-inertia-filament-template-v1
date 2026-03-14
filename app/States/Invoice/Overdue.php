<?php

namespace App\States\Invoice;

class Overdue extends InvoiceState
{
    public static string $name = 'overdue';

    public function label(): string
    {
        return 'Overdue';
    }
}
