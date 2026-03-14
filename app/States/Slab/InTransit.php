<?php

namespace App\States\Slab;

class InTransit extends SlabState
{
    public static $name = 'in_transit';

    public function label(): string
    {
        return 'In Transit';
    }
}
