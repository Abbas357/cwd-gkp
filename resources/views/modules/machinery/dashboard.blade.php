<x-machinery-layout title="Machinery Dashboard">
    @push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.42.0/apexcharts.min.css">
    <style>
        .stat-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.5rem;
        }
        .activity-timeline {
            position: relative;
            padding-left: 2rem;
        }
        .activity-timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 2px;
            background: #e9ecef;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2rem;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #4e73df;
            border: 2px solid #fff;
        }
        .alert-badge {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        .bg-light {
            background-color: #f0f0f0 !important; 
        }
    </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Machinery Dashboard</li>
    </x-slot>

    <div class="wrapper">
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card card h-100" style="background: #0000ff15; border: 1px solid #0000ff20;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Machinery</h6>
                                <h3 class="mb-0">{{ $totalMachinery }}</h3>
                                <small class="text-muted">Overall machinery count</small>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10">
                                <i class="bi bi-gear text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card h-100" style="background: #00ff0015; border: 1px solid #00ff0020;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Operational Machinery</h6>
                                <h3 class="mb-0">{{ $operationalMachinery }}</h3>
                                <small class="text-success">{{ number_format($operationalPercentage, 1) }}% of fleet</small>
                            </div>
                            <div class="stat-icon bg-success bg-opacity-10">
                                <i class="bi bi-check-circle text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card h-100" style="background: #ffd90015; border: 1px solid #ffd90020;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Allocated Machinery</h6>
                                <h3 class="mb-0">{{ $allocatedMachinery }}</h3>
                                <small class="text-primary">{{ number_format($allocatedPercentage, 1) }}% allocated</small>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10">
                                <i class="bi bi-person-check text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card h-100" style="background: #ff000015; border: 1px solid #ff000020">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">In Storage</h6>
                                <h3 class="mb-0">{{ $inStorage }}</h3>
                                <small class="text-info">{{ number_format($storagePercentage, 1) }}% in storage</small>
                            </div>
                            <div class="stat-icon bg-info bg-opacity-10">
                                <i class="bi bi-building text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card card h-100" style="background: #cbee2e15; border: 1px solid #cbee2e20">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Permanent Allocated</h6>
                                <h3 class="mb-0">{{ $permanentAllocated }}</h3>
                            </div>
                            <div class="stat-icon bg-warning bg-opacity-10">
                                <i class="bi bi-pin-angle text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card card h-100" style="background: #1065e415; border: 1px solid #1065e420">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Temporary Allocated</h6>
                                <h3 class="mb-0">{{ $temporaryAllocated }}</h3>
                            </div>
                            <div class="stat-icon bg-secondary bg-opacity-10">
                                <i class="bi bi-clock-history text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card card h-100" style="background: #00b69e15; border: 1px solid #00b69e20">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Under Maintenance</h6>
                                <h3 class="mb-0">{{ $underMaintenanceMachinery }}</h3>
                            </div>
                            <div class="stat-icon bg-danger bg-opacity-10">
                                <i class="bi bi-tools text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Monthly Allocations</h5>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary active">6 Months</button>
                            <button class="btn btn-outline-secondary">1 Year</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="monthlyAllocationsChart" style="height: 300px;"></div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Machinery Types</h5>
                            </div>
                            <div class="card-body">
                                <div id="typeChart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Power Sources</h5>
                            </div>
                            <div class="card-body">
                                <div id="powerSourceChart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Certification Status</h5>
                            </div>
                            <div class="card-body">
                                <div id="certificationStatusChart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Manufacturing Year</h5>
                            </div>
                            <div class="card-body">
                                <div id="manufacturingYearChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Recent Allocations</h5>
                    </div>
                    <div class="card-body">
                        <div class="activity-timeline">
                            @foreach($recentAllocations as $allocation)
                            <div class="timeline-item">
                                <h6 class="mb-1">{{ $allocation->machinery->manufacturer }} {{ $allocation->machinery->model }}</h6>
                                <p class="mb-0 small">Allocated to {{ $allocation?->user?->position }}</p>
                                <small class="text-muted">{{ $allocation->created_at->diffForHumans() }}</small>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Machinery Needing Attention</h5>
                    </div>
                    <div class="card-body">
                        @foreach($machineryNeedingAttention as $machinery)
                        <div class="d-flex align-items-center mb-3">
                            <span class="alert-badge {{ $machinery->operational_status == 'Non-Operational' ? 'bg-danger' : 'bg-warning' }}"></span>
                            <div>
                                <h6 class="mb-1">{{ $machinery->manufacturer }} {{ $machinery->model }}</h6>
                                <p class="mb-0 small text-muted">{{ $machinery->operational_status }}</p>
                                @if($machinery->allocation)
                                <small class="text-muted">Allocated to: {{ $machinery->allocation?->user?->position }}</small>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Upcoming Maintenance</h5>
                    </div>
                    <div class="card-body">
                        @foreach($maintenanceSchedule as $machinery)
                        <div class="d-flex align-items-center mb-3">
                            <span class="alert-badge bg-info"></span>
                            <div>
                                <h6 class="mb-1">{{ $machinery->manufacturer }} {{ $machinery->model }}</h6>
                                <p class="mb-0 small">Due: {{ date('M d, Y', strtotime($machinery->next_maintenance_date)) }}</p>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($machinery->next_maintenance_date)->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Model Distribution by Manufacturer</h5>
                    </div>
                    <div class="card-body">
                        <div id="modelsByManufacturerChart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Operating Hours Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div id="operatingHoursChart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Allocation Trends by Purpose</h5>
                    </div>
                    <div class="card-body">
                        <div id="allocationTrendsChart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.42.0/apexcharts.min.js"></script>
    <script>
        // Helper function to get color array
        function getColors(count) {
            const colors = [
                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', 
                '#858796', '#5a5c69', '#2c9faf', '#20c9a6', '#6610f2'
            ];
            return colors.slice(0, count);
        }

        // Monthly Allocations Chart
        const monthlyData = @json($monthlyAllocations);
        const monthlyOptions = {
            series: [{
                name: 'Allocations',
                data: monthlyData.map(item => item.count)
            }],
            chart: {
                type: 'area',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: monthlyData.map(item => item.month)
            },
            colors: ['#4e73df'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3
                }
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return value + " machinery"
                    }
                }
            }
        };

        new ApexCharts(document.querySelector("#monthlyAllocationsChart"), monthlyOptions).render();

        // Distribution Charts
        function createDistributionChart(elementId, data, title) {
            const options = {
                series: data.map(item => item.count),
                chart: {
                    type: 'donut',
                    height: 300
                },
                labels: data.map(item => item[title.toLowerCase()] || 'N/A'),
                colors: getColors(data.length),
                plotOptions: {
                    pie: {
                        donut: {
                            size: '50%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    offsetY: 0,
                    fontSize: '13px'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            new ApexCharts(document.querySelector(elementId), options).render();
        }

        // Create all distribution charts
        const distributions = @json($distributions);
        createDistributionChart("#typeChart", distributions.type, 'type');
        createDistributionChart("#powerSourceChart", distributions.power_source, 'power_source');
        createDistributionChart("#certificationStatusChart", distributions.certification_status, 'certification_status');
        createDistributionChart("#manufacturingYearChart", distributions.manufacturing_year, 'manufacturing_year');

        // Models by Manufacturer Chart
        const modelsByManufacturer = @json($modelsByManufacturer);
        const manufacturerLabels = Object.keys(modelsByManufacturer);
        const modelData = manufacturerLabels.map(manufacturer => ({
            name: manufacturer,
            data: modelsByManufacturer[manufacturer].map(model => ({
                x: model.model,
                y: model.count
            }))
        }));

        const modelsByManufacturerOptions = {
            series: modelData,
            chart: {
                type: 'bar',
                height: 400,
                stacked: true,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    }
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    dataLabels: {
                        total: {
                            enabled: true,
                            offsetX: 0,
                            style: {
                                fontSize: '13px',
                                fontWeight: 900
                            }
                        }
                    }
                },
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: [...new Set(Object.values(modelsByManufacturer).flat().map(item => item.model))],
                labels: {
                    formatter: function(val) {
                        return Math.abs(Math.round(val));
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Models'
                }
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function(val) {
                        return Math.abs(val) + " machinery";
                    }
                }
            },
            colors: getColors(manufacturerLabels.length),
            fill: {
                opacity: 1
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left',
                offsetX: 40
            },
            title: {
                text: 'Machinery Models by Manufacturer',
                align: 'left',
                margin: 10,
                style: {
                    fontSize: '15px'
                }
            }
        };

        new ApexCharts(document.querySelector("#modelsByManufacturerChart"), modelsByManufacturerOptions).render();

        // Operating Hours Chart
        const operatingHoursData = @json($operatingHoursStats);
        const operatingHoursOptions = {
            series: [{
                name: 'Machinery Count',
                data: operatingHoursData.map(item => item.count)
            }],
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    columnWidth: '60%',
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: operatingHoursData.map(item => item.hour_range),
            },
            yaxis: {
                title: {
                    text: 'Number of Machinery'
                }
            },
            fill: {
                opacity: 1,
                colors: ['#36b9cc']
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " machinery"
                    }
                }
            }
        };

        new ApexCharts(document.querySelector("#operatingHoursChart"), operatingHoursOptions).render();

        // Allocation Trends Chart
        const allocationTrends = @json($allocationTrends);
        const allocationTrendsSeries = Object.keys(allocationTrends).map(purpose => {
            const data = allocationTrends[purpose];
            return {
                name: purpose,
                data: data.map(item => ({
                    x: `${item.year}-${item.month.toString().padStart(2, '0')}`,
                    y: item.count
                }))
            };
        });

        const allocationTrendsOptions = {
            series: allocationTrendsSeries,
            chart: {
                type: 'line',
                height: 400,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            colors: getColors(Object.keys(allocationTrends).length),
            xaxis: {
                type: 'category',
                tickAmount: 6,
                labels: {
                    formatter: function(value) {
                        const date = new Date(value);
                        return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Number of Allocations'
                },
                min: 0
            },
            legend: {
                position: 'top'
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function(value) {
                        return value + " allocations";
                    }
                },
                x: {
                    formatter: function(value) {
                        const date = new Date(value);
                        return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
                    }
                }
            }
        };

        new ApexCharts(document.querySelector("#allocationTrendsChart"), allocationTrendsOptions).render();

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Add click handlers for chart period buttons
        document.querySelectorAll('.btn-group .btn').forEach(button => {
            button.addEventListener('click', function() {
                const buttons = this.parentElement.querySelectorAll('.btn');
                buttons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                // Here you can add logic to update the chart period
            });
        });
    </script>
    @endpush
</x-machinery-layout>