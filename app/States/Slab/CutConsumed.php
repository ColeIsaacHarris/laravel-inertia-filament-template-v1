<?php

namespace App\States\Slab;

class CutConsumed extends SlabState
{
    public static string $name = 'cut_consumed';

    public function label(): string
    {
        return 'Cut / Consumed';
    }
}
