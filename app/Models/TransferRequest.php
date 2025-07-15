<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferRequest extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('transfer_requests')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "Transfer Request {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('transfer_documents')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'application/pdf']);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withoutGlobalScopes();
    }

    public function fromOffice()
    {
        return $this->belongsTo(Office::class, 'from_office_id');
    }

    public function toOffice()
    {
        return $this->belongsTo(Office::class, 'to_office_id');
    }

    public function fromDesignation()
    {
        return $this->belongsTo(Designation::class, 'from_designation_id');
    }

    public function toDesignation()
    {
        return $this->belongsTo(Designation::class, 'to_designation_id');
    }

    public function scopeForOffice($query, $officeId)
    {
        return $query->where('to_office_id', $officeId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    protected function createPosting()
    {
        $currentPosting = $this->user->currentPosting;
        if ($currentPosting) {
            $currentPosting->endPosting($this->posting_date);
        }

        $posting = Posting::create([
            'user_id' => $this->user_id,
            'office_id' => $this->to_office_id,
            'designation_id' => $this->to_designation_id,
            'start_date' => Carbon::parse($this->posting_date)->addDay(),
            'is_current' => true,
            'remarks' => "Transfer via request #{$this->id}"
        ]);

        $this->user->refresh();

        return $posting;
    }
}