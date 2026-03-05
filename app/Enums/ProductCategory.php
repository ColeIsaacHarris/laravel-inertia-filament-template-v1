<?php

namespace App\Enums;

enum ProductCategory: string
{
    case SINK = 'sink';
    case EDGE_PROFILE = 'edge_profile';
    case ADHESIVE = 'adhesive';
    case SEALER = 'sealer';
    case SUPPORT_BRACKET = 'support_bracket';
    case SAMPLE = 'sample';
    case OTHER = 'other';
}
