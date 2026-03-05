<?php

namespace App\Enums;

enum HoldRequestStatus: string
{
    case PENDING_REVIEW = 'pending_review';
    case APPROVED = 'approved';
    case DECLINED = 'declined';
    case EXPIRED = 'expired';
}
