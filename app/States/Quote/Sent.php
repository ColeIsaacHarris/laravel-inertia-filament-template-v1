<?php

namespace App\States\Quote;

class Sent extends QuoteState
{
    public static string $name = 'sent';

    public function label(): string
    {
        return 'Sent';
    }
}
