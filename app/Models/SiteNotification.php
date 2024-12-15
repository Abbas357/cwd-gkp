<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteNotification extends Model
{
    protected $table = 'site_notifications';
    protected $fillable = ['type', 'title', 'url'];
}
