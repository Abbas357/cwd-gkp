<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationsLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public $table = 'registration_logs';
}
