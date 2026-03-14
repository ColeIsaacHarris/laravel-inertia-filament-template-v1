<?php

namespace App\States\Container;

class Loaded extends ContainerState
{
    public static string $name = 'loaded';

    public function label(): string
    {
        return 'Loaded';
    }
}
