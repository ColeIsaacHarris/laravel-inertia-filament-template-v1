<?php

namespace App\States\Quote;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    DefaultState(Draft::class),
    AllowTransition(Draft::class, Sent::class),
    AllowTransition(Sent::class, Accepted::class),
    AllowTransition(Sent::class, Declined::class),
    AllowTransition(Sent::class, Expired::class),
    AllowTransition(Sent::class, Revised::class),
]
abstract class QuoteState extends State
{
    abstract public function label(): string;
}
