<?php

namespace App\States\HoldRequest;

class Declined extends HoldRequestState
{
    public static string $name = 'declined';

    public function label(): string
    {
        return 'Declined';
    }
}
