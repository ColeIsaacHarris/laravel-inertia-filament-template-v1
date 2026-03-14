<?php

namespace App\States\HoldRequest;

class Approved extends HoldRequestState
{
    public static string $name = 'approved';

    public function label(): string
    {
        return 'Approved';
    }
}
