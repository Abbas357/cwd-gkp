<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SanctionedPost extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];
    
    protected $table = 'sanctioned_posts';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('sanction_posts')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "Sanction Post {$eventName}";
            });
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function currentPostings()
    {
        return $this->hasMany(Posting::class, 'office_id', 'office_id')
            ->where('designation_id', $this->designation_id)
            ->where('is_current', true);
    }
    
    public function getVacanciesAttribute()
    {
        return $this->total_positions - $this->currentPostings()->count();
    }
    
    public function getFilledPositionsAttribute()
    {
        return $this->currentPostings()->count();
    }
    
    public function scopeWithVacancies($query)
    {
        return $query->whereColumn('total_positions', '>', function($query) {
            $query->selectRaw('COUNT(*)')
                ->from('postings')
                ->whereColumn('postings.office_id', 'sanctioned_posts.office_id')
                ->whereColumn('postings.designation_id', 'sanctioned_posts.designation_id')
                ->where('postings.is_current', true);
        });
    }
}