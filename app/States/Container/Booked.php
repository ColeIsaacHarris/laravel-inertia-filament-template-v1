<?php

namespace App\States\Container;

class Booked extends ContainerState
{
    public static string $name = 'booked';

    public function label(): string
    {
        return 'Booked';
    }
}
