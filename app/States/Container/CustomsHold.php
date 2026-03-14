<?php

namespace App\States\Container;

class CustomsHold extends ContainerState
{
    public static string $name = 'customs_hold';

    public function label(): string
    {
        return 'Customs Hold';
    }
}
