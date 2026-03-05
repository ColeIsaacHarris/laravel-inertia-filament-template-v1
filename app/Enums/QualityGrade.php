<?php

namespace App\Enums;

enum QualityGrade: string
{
    case PREMIUM = 'premium';
    case STANDARD = 'standard';
    case COMMERCIAL = 'commercial';
    case REMNANT = 'remnant';
}
