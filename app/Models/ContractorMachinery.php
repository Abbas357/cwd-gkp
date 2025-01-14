<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Illuminate\Database\Eloquent\Builder;

class ContractorMachinery extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $table = 'contractor_machinery';

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('contractor_machinery_docs');
        $this->addMediaCollection('contractor_machinery_pics');
    }

    protected static function boot()
    {
        parent::boot();
        static::updating(function ($model) {
            if ($model->isDirty('status')) {
                $model->status_updated_at = now();
                $model->status_updated_by = request()->user()->id ?? null;
            }
        });
    }

    protected static function booted()
    {
        static::addGlobalScope('approved', function (Builder $builder) {
            $builder->where('status', 'approved')->whereNotNull('status_updated_at');
        });
    }

    public function resolveRouteBinding($value, $route = null)
    {
        return static::withoutGlobalScopes()->where('id', $value)->firstOrFail();
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
