<?php

namespace App\States\Slab;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    DefaultState(InTransit::class),

    AllowTransition(InTransit::class, Available::class),

    AllowTransition(Available::class, OnHold::class),
    AllowTransition(Available::class, Reserved::class),
    AllowTransition(Available::class, Consigned::class),
    AllowTransition(Available::class, Damaged::class),

    AllowTransition(OnHold::class, Available::class),
    AllowTransition(OnHold::class, Reserved::class),

    AllowTransition(Reserved::class, Sold::class),
    AllowTransition(Reserved::class, Available::class),

    AllowTransition(Sold::class, CutConsumed::class),
    AllowTransition(Sold::class, Returned::class),

    AllowTransition(Returned::class, Available::class),
    AllowTransition(Returned::class, Damaged::class),

    AllowTransition(Consigned::class, Available::class),
    AllowTransition(Consigned::class, Sold::class),

    AllowTransition(Damaged::class, Available::class),
]
abstract class SlabState extends State
{
    abstract public function label(): string;
}
