<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sharer extends Component
{
    public $title;
    public $url;

    public function __construct($title, $url)
    {
        $this->title = $title;
        $this->url = $url;
    }

    public function render()
    {
        return view('components.sharer');
    }
}
