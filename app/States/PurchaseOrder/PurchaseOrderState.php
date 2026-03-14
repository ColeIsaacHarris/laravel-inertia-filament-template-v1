<?php

namespace App\States\PurchaseOrder;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    DefaultState(Draft::class),
    AllowTransition(Draft::class, Submitted::class),
    AllowTransition(Submitted::class, Confirmed::class),
    AllowTransition(Submitted::class, Cancelled::class),
    AllowTransition(Confirmed::class, PartiallyReceived::class),
    AllowTransition(Confirmed::class, Cancelled::class),
    AllowTransition(PartiallyReceived::class, Received::class),
    AllowTransition(Received::class, Closed::class),
]
abstract class PurchaseOrderState extends State
{
    abstract public function label(): string;
}
