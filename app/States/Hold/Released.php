<?php

namespace App\States\Hold;

class Released extends HoldState
{
    public static string $name = 'released';

    public function label(): string
    {
        return 'Released';
    }
}
