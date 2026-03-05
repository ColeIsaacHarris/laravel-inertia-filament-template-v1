<?php

namespace App\Enums;

enum HoldType: string
{
    case COURTESY = 'courtesy';
    case STANDARD = 'standard';
    case DEPOSIT = 'deposit';
    case PROJECT = 'project';
    case BUILDER = 'builder';
}
