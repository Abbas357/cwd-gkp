<?php

namespace App\View\Components;

use Closure;
use App\Models\Setting;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class DocumentLayout extends Component
{
    public $title;
    public $showAside;

    public function __construct($title = null, $showAside = true)
    {
        $this->title = $title 
            ? $title .' | ' . setting('site_name', 'main', config('app.name'))
            : setting('site_name', 'main', config('app.name'));

        $this->showAside = $showAside;
    }

    public function render(): View
    {
        return view('layouts.apps.document', ['title' => $this->title, 'showAside' => $this->showAside]);
    }
}
