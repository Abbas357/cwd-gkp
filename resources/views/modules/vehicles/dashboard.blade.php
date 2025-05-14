<x-vehicle-layout title="Vehicle Dashboard">
    @push('style')
    <link href="{{ asset('admin/plugins/apexchart/apexcharts.min.css') }}" rel="stylesheet">
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
            padding-left: 1.68rem;
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
        .allocation-badge {
            font-size: 0.9rem;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
        }
    </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Vehicle Dashboard</li>
    </x-slot>

    <div class="wrapper">
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card card h-100" style="background: #0000ff15; border: 1px solid #0000ff50;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Vehicles</h6>
                                <h3 class="mb-0">{{ $totalVehicles }}</h3>
                                <small class="text-muted">Overall fleet size</small>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10">
                                <i class="bi bi-car-front text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card h-100" style="background: #00ff0015; border: 1px solid #00ff0050;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Functional Vehicles</h6>
                                <h3 class="mb-0">{{ $functionalVehicles }}</h3>
                                <small class="text-success">{{ number_format($functionalPercentage, 1) }}% of fleet</small>
                            </div>
                            <div class="stat-icon bg-success bg-opacity-10">
                                <i class="bi bi-check-circle text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card h-100" style="background: #ffd90015; border: 1px solid #ffd90050;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Alloted Vehicles</h6>
                                <h3 class="mb-0">{{ $allotedVehicles }}</h3>
                                <small class="text-primary">{{ number_format($allotedPercentage, 1) }}% allocated</small>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10">
                                <i class="bi bi-person-check text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card h-100" style="background: #ff000015; border: 1px solid #ff000050">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Department Pool</h6>
                                <h3 class="mb-0">{{ $departmentPoolCount }}</h3>
                                <small class="text-info">{{ number_format($poolPercentage, 1) }}% available</small>
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
                <div class="stat-card card h-100" style="background: #cbee2e15; border: 1px solid #cbee2e50">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Permanent Alloted</h6>
                                <h3 class="mb-0">{{ $permanentAlloted }}</h3>
                                <small class="text-muted">Personal: {{ $personalAllotmentCount }}</small>
                            </div>
                            <div class="stat-icon bg-warning bg-opacity-10">
                                <i class="bi bi-pin-angle text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card card h-100" style="background: #1065e415; border: 1px solid #1065e450">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Temporary Alloted</h6>
                                <h3 class="mb-0">{{ $temporaryAlloted }}</h3>
                            </div>
                            <div class="stat-icon bg-secondary bg-opacity-10">
                                <i class="bi bi-clock-history text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card card h-100" style="background: #00b69e15; border: 1px solid #00b69e50">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Condemned</h6>
                                <h3 class="mb-0">{{ $condemnedVehicles }}</h3>
                            </div>
                            <div class="stat-icon bg-danger bg-opacity-10">
                                <i class="bi bi-exclamation-triangle text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-8">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Vehicle Types</h5>
                            </div>
                            <div class="card-body">
                                <div id="typeChart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Fuel Types</h5>
                            </div>
                            <div class="card-body">
                                <div id="fuelTypeChart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Registration Status</h5>
                            </div>
                            <div class="card-body">
                                <div id="registrationStatusChart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Vehicle Colors</h5>
                            </div>
                            <div class="card-body">
                                <div id="colorChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Allocation By Type</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Personal Allotments</span>
                                <span>{{ $personalAllotmentCount }}</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-primary" style="width: {{ $totalVehicles > 0 ? ($personalAllotmentCount / $totalVehicles) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Office Pool</span>
                                <span>{{ $officePoolCount }}</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-info" style="width: {{ $totalVehicles > 0 ? ($officePoolCount / $totalVehicles) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Department Pool</span>
                                <span>{{ $departmentPoolCount }}</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" style="width: {{ $totalVehicles > 0 ? ($departmentPoolCount / $totalVehicles) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Recent Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="activity-timeline">
                            @foreach($recentAllotments as $allotment)
                            <div class="timeline-item">
                                <h6 class="mb-1">{{ $allotment->vehicle->brand }} {{ $allotment->vehicle->model }}</h6>
                                <p class="mb-0 small">
                                    @if($allotment->type === 'Pool')
                                        @if($allotment->office_id)
                                            <span class="badge bg-info">Office Pool: {{ $allotment->office->name ?? 'N/A' }}</span>
                                        @else
                                            <span class="badge bg-success">Department Pool</span>
                                        @endif
                                    @else
                                        @if($allotment->user_id)
                                            <span class="badge bg-primary">{{ $allotment->type }} to {{ $allotment->user->name }}</span>
                                        @elseif($allotment->office_id)
                                            <span class="badge bg-warning">{{ $allotment->type }} to {{ $allotment->office->name }}</span>
                                        @endif
                                    @endif
                                </p>
                                <small class="text-muted">{{ $allotment->created_at->diffForHumans() }}</small>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Vehicles Needing Attention</h5>
                    </div>
                    <div class="card-body">
                        @foreach($vehiclesNeedingAttention as $vehicle)
                        <div class="d-flex align-items-center mb-3">
                            <span class="alert-badge bg-warning"></span>
                            <div>
                                <h6 class="mb-1">{{ $vehicle->brand }} {{ $vehicle->model }}</h6>
                                <p class="mb-0 small text-muted">{{ $vehicle->functional_status }}</p>
                                @if($vehicle->allotment)
                                    @if($vehicle->allotment->user_id)
                                        <small class="text-muted">Alloted to: {{ $vehicle->allotment->user->name }}</small>
                                    @elseif($vehicle->allotment->office_id)
                                        <small class="text-muted">Alloted to: {{ $vehicle->allotment->office->name }}</small>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script>
        // Helper function to get color array
        function getColors(count) {
            const colors = [
                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', 
                '#858796', '#5a5c69', '#2c9faf', '#20c9a6', '#6610f2'
            ];
            return colors.slice(0, count);
        }

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
        createDistributionChart("#colorChart", distributions.color, 'color');
        createDistributionChart("#fuelTypeChart", distributions.fuel_type, 'fuel_type');
        createDistributionChart("#registrationStatusChart", distributions.registration_status, 'registration_status');

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
</x-vehicle-layout>