<?php

namespace App\Models;

use App\Models\Standardization;
use Spatie\MediaLibrary\HasMedia;
use App\Observers\ProductObserver;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ProductObserver::class])]
class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $guarded = [];

    protected static $recordEvents = ['updated', 'deleted'];

    protected function casts(): array
    {
        return [
            'card_issue_date' => 'datetime',
            'card_expiry_date' => 'datetime',
        ];
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('products')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Product {$eventName}";
            });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images');
    }

    public function standardization()
    {
        return $this->belongsTo(Standardization::class, 'standardization_id');
    }
}
