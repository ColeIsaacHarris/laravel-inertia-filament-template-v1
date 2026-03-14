<?php

namespace App\States\Container;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    DefaultState(Booked::class),
    AllowTransition(Booked::class, Loaded::class),
    AllowTransition(Loaded::class, InTransit::class),
    AllowTransition(InTransit::class, ArrivedAtPort::class),
    AllowTransition(ArrivedAtPort::class, CustomsHold::class),
    AllowTransition(ArrivedAtPort::class, CustomsCleared::class),
    AllowTransition(CustomsHold::class, CustomsCleared::class),
    AllowTransition(CustomsCleared::class, InTransitDomestic::class),
    AllowTransition(InTransitDomestic::class, Delivered::class),
    AllowTransition(Delivered::class, Received::class),
]
abstract class ContainerState extends State
{
    abstract public function label(): string;
}
