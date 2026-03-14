<?php

namespace App\States\Container;

class Received extends ContainerState
{
    public static string $name = 'received';

    public function label(): string
    {
        return 'Received';
    }
}
