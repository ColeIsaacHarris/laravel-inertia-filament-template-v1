<?php

namespace App\States\Quote;

class Accepted extends QuoteState
{
    public static string $name = 'accepted';

    public function label(): string
    {
        return 'Accepted';
    }
}
