<?php

namespace App\States\Container;

class ArrivedAtPort extends ContainerState
{
    public static string $name = 'arrived_at_port';

    public function label(): string
    {
        return 'Arrived at Port';
    }
}
