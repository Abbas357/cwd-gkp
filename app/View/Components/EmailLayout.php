<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;

class EmailLayout extends Component
{
    public $title;
    public $logo;
    public $contactEmail;

    public function __construct($title = 'Communication & Works Department')
    {
        $this->title = $title;
        $this->logo = asset('site/images/logo-mobile.png');
        $this->contactEmail = 'cwd.gkp@gmail.com';
    }

    public function render(): View
    {
        return view('layouts.email');
    }
}
