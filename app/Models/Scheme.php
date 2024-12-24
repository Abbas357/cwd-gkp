<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'adp_number',
        'scheme_code',
        'year',
        'scheme_name',
        'sector_name',
        'sub_sector_name',
        'local_cost',
        'foreign_cost',
        'previous_expenditure',
        'capital_allocation',
        'revenue_allocation',
        'total_allocation',
        'f_allocation',
        'tf',
        'revised_allocation',
        'prog_releases',
        'progressive_exp',
    ];
}
