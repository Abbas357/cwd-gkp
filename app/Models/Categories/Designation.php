<?php

namespace App\Models\Categories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];

    public function users() {
        return $this->hasMany(User::class);
    }
}
