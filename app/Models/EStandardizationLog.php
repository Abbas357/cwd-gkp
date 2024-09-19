<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EStandardizationLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public $table = 'e_standardization_logs';
}
