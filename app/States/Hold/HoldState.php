<?php

namespace App\States\Hold;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    DefaultState(Active::class),
    AllowTransition(Active::class, Expired::class),
    AllowTransition(Active::class, Converted::class),
    AllowTransition(Active::class, Released::class),
]
abstract class HoldState extends State
{
    abstract public function label(): string;
}
