<?php

namespace App\Enums;

enum MediaType: string
{
    case PHOTO = 'photo';
    case SLABSMITH = 'slabsmith';
    case CERTIFICATION = 'certification';
    case DOCUMENT = 'document';
}
