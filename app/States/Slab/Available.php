<?php

namespace App\States\Slab;

class Available extends SlabState
{
    public static $name = 'available';

    public function label(): string
    {
        return 'Available';
    }
}
