<?php

namespace App\States\DeliveryRequest;

class Requested extends DeliveryRequestState
{
    public static string $name = 'requested';

    public function label(): string
    {
        return 'Requested';
    }
}
