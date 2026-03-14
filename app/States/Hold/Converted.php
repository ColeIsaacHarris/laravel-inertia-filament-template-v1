<?php

namespace App\States\Hold;

class Converted extends HoldState
{
    public static string $name = 'converted';

    public function label(): string
    {
        return 'Converted';
    }
}
