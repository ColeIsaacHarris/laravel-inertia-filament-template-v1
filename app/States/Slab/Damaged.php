<?php

namespace App\States\Slab;

class Damaged extends SlabState
{
    public static $name = 'damaged';

    public function label(): string
    {
        return 'Damaged';
    }
}
