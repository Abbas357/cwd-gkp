<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public $showAside;
    public $siteName;

    public function __construct($showAside = false, $siteName = null)
    {
        $this->showAside = $showAside;
        $this->siteName = $siteName ?? config('app.name');
    }

    public function render()
    {
        return view('components.footer');
    }
}
