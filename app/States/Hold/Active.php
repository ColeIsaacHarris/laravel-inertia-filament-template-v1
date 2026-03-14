<?php

namespace App\States\Hold;

class Active extends HoldState
{
    public static string $name = 'active';

    public function label(): string
    {
        return 'Active';
    }
}
