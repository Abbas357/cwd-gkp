<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvincialEntity extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];
}
