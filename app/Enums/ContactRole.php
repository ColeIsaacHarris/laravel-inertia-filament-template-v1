<?php

namespace App\Enums;

enum ContactRole: string
{
    case PRIMARY = 'primary';
    case BILLING = 'billing';
    case SHIPPING = 'shipping';
    case DECISION_MAKER = 'decision_maker';
    case BUYER = 'buyer';
    case ACCOUNTS_PAYABLE = 'accounts_payable';
    case SITE_CONTACT = 'site_contact';
}
