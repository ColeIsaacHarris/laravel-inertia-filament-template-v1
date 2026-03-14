<?php

namespace App\States\HoldRequest;

class PendingReview extends HoldRequestState
{
    public static string $name = 'pending_review';

    public function label(): string
    {
        return 'Pending Review';
    }
}
