<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;

class EmailLayout extends Component
{
    public $title;
    public $contactEmail;

    public function __construct($title = 'Communication & Works Department')
    {
        $this->title = $title;
        $this->contactEmail = 'cwd.gkp@gmail.com';
    }

    public function render(): View
    {
        return view('layouts.email');
    }
}
