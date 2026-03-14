<?php

namespace App\States\Invoice;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    DefaultState(Draft::class),
    AllowTransition(Draft::class, Issued::class),
    AllowTransition(Issued::class, Paid::class),
    AllowTransition(Issued::class, PartiallyPaid::class),
    AllowTransition(Issued::class, Overdue::class),
    AllowTransition(Issued::class, Voided::class),
    AllowTransition(PartiallyPaid::class, Paid::class),
    AllowTransition(PartiallyPaid::class, Overdue::class),
    AllowTransition(Overdue::class, Paid::class),
    AllowTransition(Overdue::class, PartiallyPaid::class),
]
abstract class InvoiceState extends State
{
    abstract public function label(): string;
}
