<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $type;
    public $text;
    
    public function __construct($type = 'button', $text = 'Submit')
    {
        $this->type = $type;
        $this->text = $text;
    }

    public function render()
    {
        return view('components.button');
    }
}