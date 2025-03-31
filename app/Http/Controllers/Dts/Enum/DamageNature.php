<?php

namespace App\Http\Controllers\Dts\Enum;

enum DamageNature: string
{
    case CULVERT = 'Culvert';
    case RETAINING_WALL = 'Retaining Wall';
    case EMBANKMENT_DAMAGES = 'Embankment Damages';
    case SHOULDERS = 'Shoulders';
    case WC = 'WC';
    case BASE_COURSE = 'Base Course';
    case SUB_BASE = 'Sub Base';
    case CULVERTS = 'Culverts';
    case RIGID_PAVEMENT = 'Rigid Pavement';
    case KACHA_ROAD = 'Kacha Road';
    case STRUCTURE_WORK_APPROACH = 'Structure work & Approach';
    case ROAD_WASHED_AWAY = 'Road washed away';
    case LAND_SLIDING = 'Land Sliding';
    case SURFACE_OF_ROAD = 'Surface of road';
    case EARTH_WORK = 'Earth Work';
    case PCC_WORK = 'PCC Work';
    case WING_WALL = 'Wing Wall';
    case DEBRIS_DEPOSITION = 'Debris Deposition';
    case SLIPS = 'Slips';
    case BOULDERS = 'Boulders';
    case DEBRIS = 'Debris';
    case ROAD_CRUST = 'Road Crust';
    case BED_DAMAGED = 'Bed damaged';
    case BREAST_WALL = 'Breast Wall';
    case SLUSH = 'Slush';
    case ROCK_FALL = 'Rock Fall';
    case PLANKS = 'Planks';
    case BEAMS = 'Beams';
    case MULBAS = 'Mulbas';
    case EROSION = 'Erosion';
    case ACCUMULATION_OF_BOULDERS = 'Accumulation of boulders';
    case PILES = 'Piles';
    case ACTIVITYWAY = 'activityway';
    case DRAIN = 'Drain';
    case PCC_BERMS = 'PCC Berms';
}
