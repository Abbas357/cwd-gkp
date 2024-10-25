<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $title;
    public $settings;

    public function __construct($title = null)
    {
        $this->settings = Setting::first();
        $this->title = $title 
            ? $title .' | ' . ($this->settings->site_name ?? config('app.name'))
            : ($this->settings->site_name ?? config('app.name'));
    }

    public function render(): View
    {
        return view('layouts.admin.app', ['title' => $this->title, 'settings' => $this->settings]);
    }
}
