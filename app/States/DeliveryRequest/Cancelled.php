<?php

namespace App\States\DeliveryRequest;

class Cancelled extends DeliveryRequestState
{
    public static string $name = 'cancelled';

    public function label(): string
    {
        return 'Cancelled';
    }
}
