<?php

namespace App\Enums;

enum CostAllocationMethod: string
{
    case BY_SQFT = 'by_sqft';
    case BY_VALUE = 'by_value';
    case BY_WEIGHT = 'by_weight';
    case BY_UNIT_COUNT = 'by_unit_count';
    case FIXED_PER_UNIT = 'fixed_per_unit';
}
