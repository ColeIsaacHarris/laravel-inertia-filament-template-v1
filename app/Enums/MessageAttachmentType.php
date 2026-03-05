<?php

namespace App\Enums;

enum MessageAttachmentType: string
{
    case FILE = 'file';
    case ENTITY_REFERENCE = 'entity_reference';
}
