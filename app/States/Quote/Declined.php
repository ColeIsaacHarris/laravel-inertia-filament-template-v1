<?php

namespace App\States\Quote;

class Declined extends QuoteState
{
    public static string $name = 'declined';

    public function label(): string
    {
        return 'Declined';
    }
}
