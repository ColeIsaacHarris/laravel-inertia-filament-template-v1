<?php

namespace App\States\Slab;

class OnHold extends SlabState
{
    public static $name = 'on_hold';

    public function label(): string
    {
        return 'On Hold';
    }
}
