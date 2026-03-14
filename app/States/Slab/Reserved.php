<?php

namespace App\States\Slab;

class Reserved extends SlabState
{
    public static $name = 'reserved';

    public function label(): string
    {
        return 'Reserved';
    }
}
