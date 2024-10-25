<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\View\View;
use Illuminate\View\Component;

class MainLayout extends Component
{
    public $title;
    public $settings;
    public $ogImage;

    public function __construct($title = null, $ogImage = null)
    {
        $this->settings = Setting::first();
        
        $this->title = $title 
            ? $title .' | ' . ($this->settings->site_name ?? config('app.name'))
            : ($this->settings->site_name ?? config('app.name'));
        
        $this->ogImage = $ogImage ?? asset('site/img/logo-mobile.png');
    }

    public function render(): View
    {
        return view('layouts.site.app', [
            'title' => $this->title,
            'settings' => $this->settings,
            'ogImage' => $this->ogImage
        ]);
    }
}
