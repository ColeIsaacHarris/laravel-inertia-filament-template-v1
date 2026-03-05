<?php

namespace App\Enums;

enum QuoteStatus: string
{
    case DRAFT = 'draft';
    case SENT = 'sent';
    case EXPIRED = 'expired';
    case ACCEPTED = 'accepted';
    case DECLINED = 'declined';
    case REVISED = 'revised';
}
