<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardSkeleton extends Component
{
    public int $tableRows;
    public int $tableColumns;
    public string $loadingText;
    public bool $showStatsBoxes;
    public bool $showTable;
    public bool $showCharts;
    
    public function __construct(
        int $tableRows = 6,
        int $tableColumns = 6,
        string $loadingText = 'Loading dashboard...',
        bool $showStatsBoxes = true,
        bool $showTable = true,
        bool $showCharts = true
    ) {
        $this->tableRows = $tableRows;
        $this->tableColumns = $tableColumns;
        $this->loadingText = $loadingText;
        $this->showStatsBoxes = $showStatsBoxes;
        $this->showTable = $showTable;
        $this->showCharts = $showCharts;
    }

    public function render(): View|Closure|string
    {
        return view('components.dashboard-skeleton');
    }
}