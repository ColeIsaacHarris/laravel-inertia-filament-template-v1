<?php

namespace App\Enums;

enum MovementType: string
{
    case RECEIPT = 'receipt';
    case TRANSFER = 'transfer';
    case BIN_MOVE = 'bin_move';
    case PICK = 'pick';
    case SHIP = 'ship';
    case RETURN = 'return';
    case ADJUSTMENT = 'adjustment';
    case CONSIGNMENT_OUT = 'consignment_out';
    case CONSIGNMENT_RETURN = 'consignment_return';
}
