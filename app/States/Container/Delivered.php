<?php

namespace App\States\Container;

class Delivered extends ContainerState
{
    public static string $name = 'delivered';

    public function label(): string
    {
        return 'Delivered';
    }
}
