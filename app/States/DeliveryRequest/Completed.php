<?php

namespace App\States\DeliveryRequest;

class Completed extends DeliveryRequestState
{
    public static string $name = 'completed';

    public function label(): string
    {
        return 'Completed';
    }
}
