<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SiteNotification extends Model
{
    protected $table = 'site_notifications';
    
    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('published', function (Builder $builder) {
            $builder->whereNotNull('published_at');
        });
    }

    public function notifiable()
    {
        return $this->morphTo();
    }
}
