<?php

namespace App\Http\Controllers\Dts\Enum;

enum InfrastructureType: string
{
    case ROAD = 'Road';
    case BRIDGE = 'Bridge';
    case CULVERT = 'Culvert';
}
