<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorCategory extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];
}
