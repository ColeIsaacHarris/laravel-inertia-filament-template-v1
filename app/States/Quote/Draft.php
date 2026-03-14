<?php

namespace App\States\Quote;

class Draft extends QuoteState
{
    public static string $name = 'draft';

    public function label(): string
    {
        return 'Draft';
    }
}
