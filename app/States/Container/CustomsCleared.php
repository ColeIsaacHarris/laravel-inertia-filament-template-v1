<?php

namespace App\States\Container;

class CustomsCleared extends ContainerState
{
    public static string $name = 'customs_cleared';

    public function label(): string
    {
        return 'Customs Cleared';
    }
}
