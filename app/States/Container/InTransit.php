<?php

namespace App\States\Container;

class InTransit extends ContainerState
{
    public static string $name = 'in_transit';

    public function label(): string
    {
        return 'In Transit';
    }
}
