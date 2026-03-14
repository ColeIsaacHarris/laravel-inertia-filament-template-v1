<?php

namespace App\States\Quote;

class Revised extends QuoteState
{
    public static string $name = 'revised';

    public function label(): string
    {
        return 'Revised';
    }
}
