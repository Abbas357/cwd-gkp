<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\View\View;
use Illuminate\View\Component;

class GuestLayout extends Component
{
    public $title;

    public function __construct($title = null)
    {
        $this->title = $title 
            ? $title .' | ' . setting('site_name', 'main', config('app.name'))
            : setting('site_name', 'main', config('app.name'));
    }

    public function render(): View
    {
        return view('layouts.guest', ['title' => $this->title]);
    }
}
