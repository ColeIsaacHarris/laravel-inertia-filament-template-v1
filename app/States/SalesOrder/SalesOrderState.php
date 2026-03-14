<?php

namespace App\States\SalesOrder;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    DefaultState(Draft::class),
    AllowTransition(Draft::class, Confirmed::class),
    AllowTransition(Draft::class, Cancelled::class),
    AllowTransition(Confirmed::class, ReadyForFulfillment::class),
    AllowTransition(Confirmed::class, Cancelled::class),
    AllowTransition(ReadyForFulfillment::class, PartiallyShipped::class),
    AllowTransition(ReadyForFulfillment::class, Shipped::class),
    AllowTransition(PartiallyShipped::class, Shipped::class),
    AllowTransition(Shipped::class, Invoiced::class),
    AllowTransition(Invoiced::class, Closed::class),
]
abstract class SalesOrderState extends State
{
    abstract public function label(): string;
}
