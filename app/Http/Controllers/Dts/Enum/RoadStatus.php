<?php

namespace App\Http\Controllers\Dts\Enum;

enum RoadStatus: string
{
    case PARTIALLY_RESTORED = 'Partially restored';
    case FULLY_RESTORED = 'Fully restored';
    case NOT_RESTORED = 'Not restored';
}