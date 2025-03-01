<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public $logoUrl;
    public $appName;
    
    public $bgColor;
    public $bgImage;
    public $textColor;
    public $collapsible;
    public $darkMode;
    
    public $componentId;

    public function __construct(
        $logoUrl = null,
        $appName = 'C&W Departments',
        $bgColor = 'red',
        $bgImage = null,
        $textColor = null,
        $collapsible = true,
        $darkMode = false
    ) {
        $this->logoUrl = $logoUrl ?? asset('admin/images/logo-square.png');
        $this->appName = $appName;
        $this->bgColor = $bgColor;
        $this->bgImage = $bgImage;
        $this->textColor = $textColor;
        $this->collapsible = $collapsible;
        $this->darkMode = $darkMode;
        
        $this->componentId = 'sidebar-' . md5(uniqid('', true));
    }

    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}