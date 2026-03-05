<?php

namespace App\Enums;

enum ThreadType: string
{
    case GENERAL_INQUIRY = 'general_inquiry';
    case HOLD_THREAD = 'hold_thread';
    case ORDER_THREAD = 'order_thread';
    case DELIVERY_THREAD = 'delivery_thread';
    case SLAB_INQUIRY = 'slab_inquiry';
}
