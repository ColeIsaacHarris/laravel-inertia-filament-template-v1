<?php

namespace App\States\HoldRequest;

class Expired extends HoldRequestState
{
    public static string $name = 'expired';

    public function label(): string
    {
        return 'Expired';
    }
}
