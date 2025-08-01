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

    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'Approved');
    }

    public function isPending()
    {
        return $this->status === 'Pending';
    }

    public function isApproved()
    {
        return $this->status === 'Approved';
    }

    public function isRejected()
    {
        return $this->status === 'Rejected';
    }

    public function reject($remarks = null)
    {
        $this->update([
            'status' => 'Rejected',
            'remarks' => $remarks
        ]);

        return $this;
    }

    public function approved()
    {
        $this->update([
            'status' => 'Approved',
        ]);

        $this->createPosting();

        return $this;
    }

    protected function createPosting()
    {
        // Vacating existing user on target post
        $previousPosting = Office::findOrFail($this->to_office_id)
            ->currentPostings()
            ->where('designation_id', $this->to_designation_id)
            ->where('is_current', true)
            ->first();
            
        if ($previousPosting) {
            $previousPosting->update([
                'is_current' => false,
                'end_date' => $this->posting_date
            ]);
        }

        // Vacating the current user from the current post
        $currentPosting = $this->user->currentPosting;
        if ($currentPosting) {
            $currentPosting->endPosting($this->posting_date);
        }

        // Give them a new posting
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