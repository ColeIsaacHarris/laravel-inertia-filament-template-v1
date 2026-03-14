<?php

namespace App\States\DeliveryRequest;

class Declined extends DeliveryRequestState
{
    public static string $name = 'declined';

    public function label(): string
    {
        return 'Declined';
    }
}
