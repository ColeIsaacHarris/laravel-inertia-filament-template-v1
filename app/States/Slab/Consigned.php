<?php

namespace App\States\Slab;

class Consigned extends SlabState
{
    public static $name = 'consigned';

    public function label(): string
    {
        return 'Consigned';
    }
}
