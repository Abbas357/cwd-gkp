<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $title;

    public function __construct($title = null)
    {
        $this->title = $title ? $title .' | ' .config('app.name') : '' . config('app.name');
    }

    public function render(): View
    {
        return view('layouts.admin.app', ['title' => $this->title]);
    }
}
