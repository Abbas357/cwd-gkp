<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProvincialOwnReceipt extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'month' => 'date',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2);
    }

    public function getFormattedMonthAttribute()
    {
        return Carbon::parse($this->month)->format('F Y');
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        if ($startDate) {
            $query->where('month', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('month', '<=', $endDate);
        }
        
        return $query;
    }

    public function scopeByDistrict($query, $districtId)
    {
        return $districtId ? $query->where('district_id', $districtId) : $query;
    }

    public function scopeByType($query, $type)
    {
        return $type ? $query->where('type', $type) : $query;
    }

    public function scopeByDdoCode($query, $ddoCode)
    {
        return $ddoCode ? $query->where('ddo_code', $ddoCode) : $query;
    }

    public function scopeByUser($query, $userId)
    {
        return $userId ? $query->where('user_id', $userId) : $query;
    }
}
