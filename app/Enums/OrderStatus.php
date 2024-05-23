<?php

namespace App\Enums;

enum OrderStatus: string
{
    case INIT = 'INIT';
    case IN_PROGRESS = 'IN_PROGRESS';
    case FAILED = 'FAILED';
    case SUCCEED = 'SUCCEED';
}
