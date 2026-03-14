<?php

namespace App\States\DeliveryRequest;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    DefaultState(Requested::class),
    AllowTransition(Requested::class, Confirmed::class),
    AllowTransition(Requested::class, AlternativeProposed::class),
    AllowTransition(Requested::class, Declined::class),
    AllowTransition(AlternativeProposed::class, Confirmed::class),
    AllowTransition(AlternativeProposed::class, Declined::class),
    AllowTransition(Confirmed::class, Completed::class),
    AllowTransition(Confirmed::class, Cancelled::class),
]
abstract class DeliveryRequestState extends State
{
    abstract public function label(): string;
}
