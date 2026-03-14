<?php

namespace App\States\DeliveryRequest;

class AlternativeProposed extends DeliveryRequestState
{
    public static string $name = 'alternative_proposed';

    public function label(): string
    {
        return 'Alternative Proposed';
    }
}
