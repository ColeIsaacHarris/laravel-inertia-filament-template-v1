<?php

namespace App\Enums;

enum PricingModel: string
{
    case PER_SQFT = 'per_sqft';
    case PER_SLAB = 'per_slab';
    case PER_BUNDLE = 'per_bundle';
}
