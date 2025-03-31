<?php

namespace App\Http\Controllers\Dts\Enum;

enum DamageStatus: string
{
    case PARTIALLY_DAMAGED = 'Partially Damaged';
    case FULLY_DAMAGED = 'Fully Damaged';
}
