<?php

namespace App\States\Container;

class InTransitDomestic extends ContainerState
{
    public static string $name = 'in_transit_domestic';

    public function label(): string
    {
        return 'In Transit (Domestic)';
    }
}
