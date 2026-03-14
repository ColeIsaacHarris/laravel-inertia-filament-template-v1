<?php

namespace App\States\Container;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    DefaultState(Loaded::class),
    AllowTransition(Booked::class, Loaded::class)
]
abstract class ContainerState extends State
{
    abstract public function label(): string;
}
