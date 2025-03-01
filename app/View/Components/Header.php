<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    public $showAside;

    public function __construct($showAside = true)
    {
        $this->showAside = $showAside;
    }

    public function render()
    {
        return view('components.header');
    }
}
