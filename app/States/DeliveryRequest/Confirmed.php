<?php

namespace App\States\DeliveryRequest;

class Confirmed extends DeliveryRequestState
{
    public static string $name = 'confirmed';

    public function label(): string
    {
        return 'Confirmed';
    }
}
