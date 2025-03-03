<x-app-layout title="Admin Dashboard">
    @push('style')
    <link href="{{ asset('admin/plugins/apexchart/apexcharts.min.css') }}" rel="stylesheet">
    <style>
        .dashboard-container {
            margin: 1.5rem auto;
            padding: 0 1.5rem;
        }
        
        .dashboard-header {
            margin-bottom: 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            padding-bottom: 1rem;
        }
        
        [data-bs-theme=dark] .dashboard-header {
            border-bottom-color: rgba(255,255,255,0.1);
        }
        
        .stat-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: none;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        
        .stat-icon {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.8rem;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }
        
        .bg-gradient-success {
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        }
        
        .bg-gradient-warning {
            background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
        }
        
        .bg-gradient-danger {
            background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%);
        }
        
        .bg-gradient-info {
            background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        }
        
        .bg-gradient-dark {
            background: linear-gradient(135deg, #5a5c69 0%, #373840 100%);
        }
        
        .bg-light {
            background-color: #f8f9fc !important; 
        }
        
        [data-bs-theme=dark] .bg-light {
            background-color: #2d2d3a !important;
        }
        
        .module-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .module-card .card-header {
            border-bottom: none;
            font-weight: 600;
            padding: 1.25rem 1.5rem;
        }
        
        .module-card .card-body {
            padding: 1.5rem;
        }
        
        .module-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.2rem;
            margin-right: 12px;
        }
        
        .recent-activity {
            position: relative;
            padding-left: 1.75rem;
        }
        
        .recent-activity::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            height: 100%;
            width: 2px;
            background: #e9ecef;
        }
        
        [data-bs-theme=dark] .recent-activity::before {
            background: #343a40;
        }
        
        .activity-item {
            position: relative;
            padding-bottom: 1.75rem;
        }
        
        .activity-item:last-child {
            padding-bottom: 0;
        }
        
        .activity-item::before {
            content: '';
            position: absolute;
            left: -1.75rem;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #4e73df;
            border: 2px solid #fff;
            z-index: 1;
        }
        
        [data-bs-theme=dark] .activity-item::before {
            border-color: #343a40;
        }
        
        .activity-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #5a5c69;
            margin-right: 10px;
        }
        
        .dashboard-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #5a5c69;
        }
        
        [data-bs-theme=dark] .dashboard-title {
            color: #e9ecef;
        }
        
        .progress {
            height: 8px;
            border-radius: 4px;
            background-color: #eaecf4;
        }
        
        [data-bs-theme=dark] .progress {
            background-color: #343a40;
        }
        
        .badge {
            padding: 0.35em 0.65em;
            font-weight: 600;
        }
        
        .chart-container {
            position: relative;
            min-height: 300px;
        }
        
        .content-filter {
            display: flex;
            gap: 8px;
            margin-bottom: 1rem;
        }
        
        .filter-btn {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .filter-btn.active {
            background-color: #4e73df;
            color: white;
        }
        
        .card-highlight {
            border-left: 4px solid;
            transition: all 0.3s ease;
        }
        
        .card-highlight:hover {
            transform: translateX(5px);
        }
        
        .metric-value {
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1.2;
        }
        
        .metric-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.7;
        }
        
        .trend-indicator {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .trend-up {
            background-color: rgba(28, 200, 138, 0.1);
            color: #1cc88a;
        }
        
        .trend-down {
            background-color: rgba(231, 74, 59, 0.1);
            color: #e74a3b;
        }
        
        .content-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .content-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 0.75rem;
            transition: all 0.2s;
            background-color: rgba(0,0,0,0.02);
        }
        
        [data-bs-theme=dark] .content-item {
            background-color: rgba(255,255,255,0.05);
        }
        
        .content-item:hover {
            background-color: rgba(0,0,0,0.04);
            transform: translateX(5px);
        }
        
        [data-bs-theme=dark] .content-item:hover {
            background-color: rgba(255,255,255,0.08);
        }
        
        .content-type-badge {
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-tooltip {
            cursor: help;
        }
        
        .stat-trend {
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            margin-top: 0.5rem;
        }
        
        .content-visual {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin-right: 1rem;
            background-color: #f0f0f0;
            color: #5a5c69;
        }
        
        [data-bs-theme=dark] .content-visual {
            background-color: #343a40;
            color: #e9ecef;
        }
    </style>
    @endpush

    <div class="dashboard-container">
        <div class="dashboard-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="dashboard-title">Website Admin Dashboard</h1>
                <p class="text-muted mb-0">Overview of website content and performance</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" id="refreshStats">
                    <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                </button>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="actionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-plus-lg me-1"></i> Add Content
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="actionsDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.news.index') }}">New Article</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.events.index') }}">New Event</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.tenders.index') }}">New Tender</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.gallery.index') }}">New Gallery</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Top Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card card h-100 bg-gradient-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white text-opacity-75 mb-2">Total Content</h6>
                                <h3 class="mb-0">{{ number_format($totalContent) }}</h3>
                                <div class="stat-trend">
                                    <span class="badge bg-white bg-opacity-25 me-1">
                                        <i class="bi bi-collection"></i>
                                    </span>
                                    <span>All website items</span>
                                </div>
                            </div>
                            <div class="stat-icon bg-white bg-opacity-25">
                                <i class="bi bi-collection text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card h-100 bg-gradient-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white text-opacity-75 mb-2">Published</h6>
                                <h3 class="mb-0">{{ number_format($publishedContent) }}</h3>
                                <div class="stat-trend">
                                    <span class="badge bg-white bg-opacity-25 me-1">
                                        {{ number_format($publishedPercentage, 1) }}%
                                    </span>
                                    <span>of total content</span>
                                </div>
                            </div>
                            <div class="stat-icon bg-white bg-opacity-25">
                                <i class="bi bi-check-circle text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card h-100 bg-gradient-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white text-opacity-75 mb-2">In Draft</h6>
                                <h3 class="mb-0">{{ number_format($draftContent) }}</h3>
                                <div class="stat-trend">
                                    <span class="badge bg-white bg-opacity-25 me-1">
                                        {{ number_format($draftPercentage, 1) }}%
                                    </span>
                                    <span>of total content</span>
                                </div>
                            </div>
                            <div class="stat-icon bg-white bg-opacity-25">
                                <i class="bi bi-pencil-square text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card h-100 bg-gradient-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white text-opacity-75 mb-2">Archived</h6>
                                <h3 class="mb-0">{{ number_format($archivedContent) }}</h3>
                                <div class="stat-trend">
                                    <span class="badge bg-white bg-opacity-25 me-1">
                                        {{ number_format($archivedPercentage, 1) }}%
                                    </span>
                                    <span>of total content</span>
                                </div>
                            </div>
                            <div class="stat-icon bg-white bg-opacity-25">
                                <i class="bi bi-archive text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Performance Metrics Row -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Content Activity Overview</h5>
                        <div class="content-filter">
                            <div class="filter-btn active" data-chart="views">Views</div>
                            <div class="filter-btn" data-chart="creation">Creation</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <div id="viewsChart" class="chart-element active" style="height: 300px;"></div>
                            <div id="creationChart" class="chart-element" style="height: 300px; display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Performance Metrics</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-4">
                            <div>
                                <p class="metric-label mb-1">Total Views</p>
                                <h2 class="metric-value mb-0">{{ number_format($performanceMetrics['totalViews']) }}</h2>
                                <span class="trend-indicator trend-up mt-2">
                                    <i class="bi bi-graph-up me-1"></i> 12% from last month
                                </span>
                            </div>
                            <div>
                                <p class="metric-label mb-1">Avg. Views Per Content</p>
                                <h2 class="metric-value mb-0">{{ number_format($performanceMetrics['avgViewsPerContent']) }}</h2>
                            </div>
                            <div>
                                <p class="metric-label mb-1">Content Health</p>
                                <div class="progress mb-2" style="height: 10px;">
                                    <div class="progress-bar bg-success" style="width: {{ $publishedPercentage }}%" role="progressbar"></div>
                                    <div class="progress-bar bg-warning" style="width: {{ $draftPercentage }}%" role="progressbar"></div>
                                    <div class="progress-bar bg-danger" style="width: {{ $archivedPercentage }}%" role="progressbar"></div>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span>{{ $performanceMetrics['publishedRatio'] }} published</span>
                                    <span class="info-tooltip" data-bs-toggle="tooltip" title="Higher published ratio indicates better content health">
                                        <i class="bi bi-info-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Content Distribution and Top Content -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Content Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div class="row h-100">
                            <div class="col-md-7">
                                <div id="contentDistributionChart" style="height: 280px;"></div>
                            </div>
                            <div class="col-md-5 d-flex flex-column justify-content-center">
                                <div class="text-center mb-3">
                                    <h4 class="mb-0">{{ $totalContent }}</h4>
                                    <p class="text-muted">Total Content Items</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    @foreach($contentStatusData as $status)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span>{{ $status['status'] }}</span>
                                        <span class="badge" style="background-color: {{ $status['color'] }}">{{ $status['count'] }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Top Performing Content</h5>
                    </div>
                    <div class="card-body">
                        <ul class="content-list">
                            @foreach($mostViewedContent as $content)
                            <li class="content-item">
                                <div class="content-visual">
                                    <i class="bi {{ 
                                        $content['type'] == 'News' ? 'bi-newspaper' : 
                                        ($content['type'] == 'Event' ? 'bi-calendar-event' : 
                                        ($content['type'] == 'Tender' ? 'bi-briefcase' : 
                                        ($content['type'] == 'Gallery' ? 'bi-images' : 'bi-file-text'))) 
                                    }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1 text-truncate" style="max-width: 280px;">{{ $content['title'] }}</h6>
                                        <span class="badge bg-primary">{{ number_format($content['views_count']) }} views</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="content-type-badge me-2" style="
                                            background-color: {{ 
                                                $content['type'] == 'News' ? '#1cc7d015' : 
                                                ($content['type'] == 'Event' ? '#96bb0515' : 
                                                ($content['type'] == 'Tender' ? '#ff000d15' : 
                                                ($content['type'] == 'Gallery' ? '#146eb415' : '#6c757d15'))) 
                                            }};
                                            color: {{ 
                                                $content['type'] == 'News' ? '#1cc7d0' : 
                                                ($content['type'] == 'Event' ? '#96bb05' : 
                                                ($content['type'] == 'Tender' ? '#ff000d' : 
                                                ($content['type'] == 'Gallery' ? '#146eb4' : '#6c757d'))) 
                                            }};">
                                            {{ $content['type'] }}
                                        </span>
                                        <small class="text-muted">Created {{ \Carbon\Carbon::parse($content['created_at'])->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Module Stats and Recent Activity -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Module Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($moduleStats as $type => $stats)
                            <div class="col-md-6">
                                <div class="module-card card h-100">
                                    <div class="card-header d-flex align-items-center bg-light">
                                        <div class="module-icon 
                                            {{ $type == 'News' ? 'bg-gradient-primary' : 
                                            ($type == 'Event' ? 'bg-gradient-success' : 
                                            ($type == 'Tender' ? 'bg-gradient-warning' : 
                                            ($type == 'Gallery' ? 'bg-gradient-info' : 'bg-gradient-dark'))) }} 
                                            text-white">
                                            <i class="bi 
                                                {{ $type == 'News' ? 'bi-newspaper' : 
                                                ($type == 'Event' ? 'bi-calendar-event' : 
                                                ($type == 'Tender' ? 'bi-briefcase' : 
                                                ($type == 'Gallery' ? 'bi-images' : 'bi-file-text'))) }}">
                                            </i>
                                        </div>
                                        <span>{{ $type }}</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <h4 class="mb-0">{{ number_format($stats['total']) }}</h4>
                                                <small class="text-muted">Total Items</small>
                                            </div>
                                            <div class="col">
                                                <h4 class="mb-0">{{ number_format($stats['views']) }}</h4>
                                                <small class="text-muted">Total Views</small>
                                            </div>
                                        </div>
                                        <div class="progress mb-3" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: {{ $stats['publishedPercentage'] }}%" role="progressbar"></div>
                                            <div class="progress-bar bg-warning" style="width: {{ $stats['draftPercentage'] }}%" role="progressbar"></div>
                                            <div class="progress-bar bg-danger" style="width: {{ $stats['archivedPercentage'] }}%" role="progressbar"></div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="badge bg-success">{{ $stats['published'] }} Published</span>
                                            <span class="badge bg-warning">{{ $stats['draft'] }} Draft</span>
                                            <span class="badge bg-danger">{{ $stats['archived'] }} Archived</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Recent Activity</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="recent-activity">
                            @foreach($recentActivities as $activity)
                            <div class="activity-item">
                                <div class="d-flex">
                                    @if($activity['causer_avatar'])
                                        <img src="{{ $activity['causer_avatar'] }}" alt="{{ $activity['causer'] }}" class="activity-avatar">
                                    @else
                                        <div class="activity-avatar">
                                            {{ substr($activity['causer'], 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="mb-1">{{ $activity['description'] }}</p>
                                        <div class="d-flex align-items-center">
                                            <small class="text-muted">{{ $activity['causer'] }}</small>
                                            <span class="mx-1">•</span>
                                            <small class="text-muted">{{ $activity['time_ago'] }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    @push('script')
    <script src="{{ asset('admin/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Content Distribution Chart
            const distributionOptions = {
                series: [
                    @foreach($contentStatusData as $status)
                    {{ $status['count'] }},
                    @endforeach
                ],
                labels: [
                    @foreach($contentStatusData as $status)
                    '{{ $status['status'] }}',
                    @endforeach
                ],
                chart: {
                    type: 'donut',
                    height: 280
                },
                colors: [
                    @foreach($contentStatusData as $status)
                    '{{ $status['color'] }}',
                    @endforeach
                ],
                legend: {
                    position: 'bottom'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '50%'
                        }
                    }
                }
            };
            
            const distributionChart = new ApexCharts(document.querySelector("#contentDistributionChart"), distributionOptions);
            distributionChart.render();
            
            // Views Trend Chart
            const viewsTrendData = @json($viewsTrend);
            const viewsOptions = {
                series: [{
                    name: 'Views',
                    data: viewsTrendData.map(item => item.views)
                }],
                chart: {
                    height: 300,
                    type: 'area',
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                colors: ['#4e73df'],
                xaxis: {
                    categories: viewsTrendData.map(item => item.date),
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toLocaleString()
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3,
                        stops: [0, 90, 100]
                    }
                }
            };
            
            const viewsChart = new ApexCharts(document.querySelector("#viewsChart"), viewsOptions);
            viewsChart.render();
            
            // Content Creation Trend Chart
            const creationTrendData = @json($contentCreationTrend);
            const creationOptions = {
                series: [{
                    name: 'Content Created',
                    data: creationTrendData.map(item => item.count)
                }],
                chart: {
                    height: 300,
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#1cc88a'],
                xaxis: {
                    categories: creationTrendData.map(item => item.date),
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        dataLabels: {
                            position: 'top'
                        },
                    }
                },
                dataLabels: {
                    enabled: false
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toLocaleString() + ' items'
                        }
                    }
                }
            };
            
            const creationChart = new ApexCharts(document.querySelector("#creationChart"), creationOptions);
            creationChart.render();
            
            // Filter buttons for charts
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const chartType = this.getAttribute('data-chart');
                    
                    // Update active button
                    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show selected chart
                    document.querySelectorAll('.chart-element').forEach(chart => chart.style.display = 'none');
                    document.getElementById(chartType + 'Chart').style.display = 'block';
                });
            });
            
            // Refresh button
            document.getElementById('refreshStats').addEventListener('click', function() {
                this.disabled = true;
                this.innerHTML = '<i class="bi bi-arrow-clockwise me-1"></i> Refreshing...';
                
                // Simulate refresh (would be AJAX in production)
                setTimeout(() => {
                    this.disabled = false;
                    this.innerHTML = '<i class="bi bi-arrow-clockwise me-1"></i> Refresh';
                    
                    // Show success toast
                    const toastEl = document.createElement('div');
                    toastEl.className = 'toast align-items-center text-white bg-success';
                    toastEl.setAttribute('role', 'alert');
                    toastEl.setAttribute('aria-live', 'assertive');
                    toastEl.setAttribute('aria-atomic', 'true');
                    toastEl.innerHTML = `
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="bi bi-check-circle me-2"></i> Dashboard data refreshed successfully.
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    `;
                    
                    document.body.appendChild(toastEl);
                    const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                    toast.show();
                    
                    setTimeout(() => {
                        toastEl.remove();
                    }, 3500);
                }, 1000);
            });
        });
    </script>
    @endpush
</x-app-layout>