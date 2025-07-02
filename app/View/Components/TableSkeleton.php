<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableSkeleton extends Component
{
    public int $rows;
    public int $columns;
    public ?string $title;
    public bool $showHeader;
    public string $loadingText;
    
    public function __construct(
        int $rows = 6,
        int $columns = 6,
        ?string $title = null,
        bool $showHeader = true,
        string $loadingText = 'Loading...'
    ) {
        $this->rows = $rows;
        $this->columns = $columns;
        $this->title = $title;
        $this->showHeader = $showHeader;
        $this->loadingText = $loadingText;
    }

    public function render(): View|Closure|string
    {
        return view('components.table-skeleton');
    }
}