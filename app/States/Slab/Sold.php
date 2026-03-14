<?php

namespace App\States\Slab;

class Sold extends SlabState
{
    public static $name = 'sold';

    public function label(): string
    {
        return 'Sold';
    }
}
