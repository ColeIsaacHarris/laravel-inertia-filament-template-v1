<?php

namespace App\States\Hold;

class Expired extends HoldState
{
    public static string $name = 'expired';

    public function label(): string
    {
        return 'Expired';
    }
}
