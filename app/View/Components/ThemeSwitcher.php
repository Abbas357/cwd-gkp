<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ThemeSwitcher extends Component
{
    public $themes;
    public $currentTheme;

    public function __construct($currentTheme = 'LightTheme')
    {
        $this->currentTheme = $currentTheme;
        $this->themes = [
            ['id' => 'LightTheme', 'icon' => 'bi-brightness-high', 'label' => 'Light'],
            ['id' => 'DarkTheme', 'icon' => 'bi-moon', 'label' => 'Dark'],
            ['id' => 'SemiDarkTheme', 'icon' => 'bi-circle-half', 'label' => 'Semi Dark'],
            ['id' => 'BorderedTheme', 'icon' => 'bi-border-style', 'label' => 'Bordered'],
        ];
    }

    public function render()
    {
        return view('layouts.partials.admin.components.theme-switcher');
    }
}
