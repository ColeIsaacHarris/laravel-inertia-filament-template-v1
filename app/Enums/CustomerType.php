<?php

namespace App\Enums;

enum CustomerType: string
{
    case FABRICATOR = 'fabricator';
    case BUILDER = 'builder';
    case DESIGNER = 'designer';
    case RETAIL_HOMEOWNER = 'retail_homeowner';
    case CONTRACTOR = 'contractor';
    case ARCHITECT = 'architect';
}
