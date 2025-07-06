<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormSkeleton extends Component
{
    public int $tabs;
    public int $inputRows;
    public int $inputColumns;
    public int $textareas;
    public string $loadingText;
    public bool $showHeader;
    public bool $showFooter;
    public bool $showCloseBtn;
    public bool $showLoadingText;
    public bool $noBorder;
    public bool $noPadding;
    
    public function __construct(
        int $tabs = 4,
        int $inputRows = 3,
        int $inputColumns = 2,
        int $textareas = 1,
        string $loadingText = 'Loading...',
        bool $showHeader = true,
        bool $showFooter = true,
        bool $showCloseBtn = true,
        bool $showLoadingText = true,
        bool $noBorder = false,
        bool $noPadding = false
    ) {
        $this->tabs = $tabs;
        $this->inputRows = $inputRows;
        $this->inputColumns = $inputColumns;
        $this->textareas = $textareas;
        $this->loadingText = $loadingText;
        $this->showHeader = $showHeader;
        $this->showFooter = $showFooter;
        $this->showCloseBtn = $showCloseBtn;
        $this->showLoadingText = $showLoadingText;
        $this->noBorder = $noBorder;
        $this->noPadding = $noPadding;
    }

    public function render(): View|Closure|string
    {
        return view('components.form-skeleton');
    }
}