<?php

namespace App\View\Components;

use App\Models\Setting;
use Illuminate\View\View;
use Illuminate\View\Component;

class MainLayout extends Component
{
    public $title;
    public $ogImage;

    public function __construct($title = null, $ogImage = null)
    {
        $this->title = $title 
            ? $title .' | ' . setting('site_name', 'main', config('app.name'))
            : setting('site_name', 'main', config('app.name'));
        
        $this->ogImage = $ogImage ?? asset('site/images/logo-square.png');
    }

    public function render(): View
    {
        return view('layouts.site.index', [
            'title' => $this->title,
            'ogImage' => $this->ogImage
        ]);
    }
}
