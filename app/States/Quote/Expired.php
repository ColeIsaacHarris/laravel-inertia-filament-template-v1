<?php

namespace App\States\Quote;

class Expired extends QuoteState
{
    public static string $name = 'expired';

    public function label(): string
    {
        return 'Expired';
    }
}
