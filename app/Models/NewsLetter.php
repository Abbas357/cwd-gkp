<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsLetter extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'subscribed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope('subscribed', function (Builder $builder) {
            $builder->whereNotNull('unsubscribe_token');
        });
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }
}
