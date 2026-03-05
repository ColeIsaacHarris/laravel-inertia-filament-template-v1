<?php

namespace App\Enums;

enum PaymentTerms: string
{
    case COD = 'cod';
    case NET_15 = 'net_15';
    case NET_30 = 'net_30';
    case NET_45 = 'net_45';
    case NET_60 = 'net_60';
    case LETTER_OF_CREDIT = 'letter_of_credit';
    case CREDIT_CARD = 'credit_card';
}
