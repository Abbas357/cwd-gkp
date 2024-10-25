<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\View\View;
use Illuminate\View\Component;

class GuestLayout extends Component
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
        return view('layouts.guest', ['title' => $this->title, 'settings' => $this->settings]);
    }
}
