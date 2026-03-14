<?php

namespace App\States\Slab;

class Returned extends SlabState
{
    public static $name = 'returned';

    public function label(): string
    {
        return 'Returned';
    }
}
