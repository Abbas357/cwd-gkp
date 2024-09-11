<?php

namespace App\Models;

use App\Models\Categories\Office;
use App\Models\Categories\Designation;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_number',
        'landline_number',
        'designation',
        'cnic',
        'office',
        'otp',
        'is_active',
        'is_suspended',
        'password_updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password_updated_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function boss()
    {
        // $boss = $user->boss->first();
        return $this->belongsToMany(User::class, 'user_hierarchy', 'user_id', 'boss_id');
    }

    public function subordinates()
    {
        // $subordinates = $user->subordinates;
        return $this->belongsToMany(User::class, 'user_hierarchy', 'boss_id', 'user_id');
    }

    public function districts()
    {
        return $this->belongsToMany(District::class, 'district_user', 'user_id', 'district_id');
    }
}
