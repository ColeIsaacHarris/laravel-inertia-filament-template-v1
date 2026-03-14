<?php

namespace App\States\HoldRequest;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    DefaultState(PendingReview::class),
    AllowTransition(PendingReview::class, Approved::class),
    AllowTransition(PendingReview::class, Declined::class),
    AllowTransition(PendingReview::class, Expired::class),
]
abstract class HoldRequestState extends State
{
    abstract public function label(): string;
}
