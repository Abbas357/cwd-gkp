<link href="{{ asset('admin/plugins/apexchart/apexcharts.min.css') }}" rel="stylesheet">
<div class="wrapper">
    <!-- Overview Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card card h-100" style="background: #0000ff15; border: 1px solid #0000ff50;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total {{ $type }}s</h6>
                            <h3 class="mb-0">{{ $totalInfrastructure }}</h3>
                            <small class="text-muted">Overall infrastructure</small>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10">
                            <i class="bi bi-building text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card card h-100" style="background: #ff000015; border: 1px solid #ff000050;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Damaged {{ $type }}s</h6>
                            <h3 class="mb-0">{{ $totalDamages }}</h3>
                            <small class="text-danger">{{ $totalInfrastructure > 0 ? number_format(($totalDamages / $totalInfrastructure) * 100, 1) : 0 }}% affected</small>
                        </div>
                        <div class="stat-icon bg-danger bg-opacity-10">
                            <i class="bi bi-exclamation-triangle text-danger"></i>
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
                            <h6 class="text-muted mb-2">Restored {{ $type }}s</h6>
                            <h3 class="mb-0">{{ $fullyRestored + $partiallyRestored }}</h3>
                            <small class="text-success">{{ $totalDamages > 0 ? number_format((($fullyRestored + $partiallyRestored) / $totalDamages) * 100, 1) : 0 }}% restored</small>
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
                            <h6 class="text-muted mb-2">Estimated Cost</h6>
                            <h3 class="mb-0">Rs {{ number_format(($totalRestorationCost + $totalRehabilitationCost)) }}M</h3>
                            <small class="text-warning">Total restoration & rehabilitation</small>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10">
                            <i class="bi bi-cash-coin text-warning"></i>
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
                            <h6 class="text-muted mb-2">Fully Restored</h6>
                            <h3 class="mb-0">{{ $fullyRestored }}</h3>
                            <small class="text-success">{{ $totalDamages > 0 ? number_format(($fullyRestored / $totalDamages) * 100, 1) : 0 }}% of damaged</small>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10">
                            <i class="bi bi-check-all text-success"></i>
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
                            <h6 class="text-muted mb-2">Partially Restored</h6>
                            <h3 class="mb-0">{{ $partiallyRestored }}</h3>
                            <small class="text-info">{{ $totalDamages > 0 ? number_format(($partiallyRestored / $totalDamages) * 100, 1) : 0 }}% of damaged</small>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10">
                            <i class="bi bi-check text-info"></i>
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
                            <h6 class="text-muted mb-2">Not Restored</h6>
                            <h3 class="mb-0">{{ $notRestored }}</h3>
                            <small class="text-danger">{{ $totalDamages > 0 ? number_format(($notRestored / $totalDamages) * 100, 1) : 0 }}% of damaged</small>
                        </div>
                        <div class="stat-icon bg-danger bg-opacity-10">
                            <i class="bi bi-x-circle text-danger"></i>
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
                            <h5 class="card-title mb-0">Damage Status</h5>
                        </div>
                        <div class="card-body">
                            <div id="damageStatusChart" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">Restoration Status</h5>
                        </div>
                        <div class="card-body">
                            <div id="restorationStatusChart" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">{{ $type }} Damage Reports by Month ({{ setting('session', 'dmis') }})</h5>
                        </div>
                        <div class="card-body">
                            <div id="monthlyDamageChart" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Most Affected Districts</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>District</th>
                                    <th>Total {{ $type }}s</th>
                                    <th>Damaged</th>
                                    <th>Length (KM)</th>
                                    <th>Cost (Million Rs.)</th>
                                    <th>Restoration Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mostAffectedDistricts as $district)
                                <tr>
                                    <td><span class="district-name">{{ $district->name }}</span></td>
                                    <td>{{ $district->infrastructure_count }}</td>
                                    <td>{{ $district->damage_count }}</td>
                                    <td>{{ number_format($district->damaged_length, 2) }}</td>
                                    <td>{{ number_format(($district->restoration_cost + $district->rehabilitation_cost)) }}</td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            @php
                                            $totalDamageCount = $district->not_restored + $district->partially_restored + $district->fully_restored;
                                            $notRestoredPercent = $totalDamageCount > 0 ? ($district->not_restored / $totalDamageCount) * 100 : 0;
                                            $partiallyRestoredPercent = $totalDamageCount > 0 ? ($district->partially_restored / $totalDamageCount) * 100 : 0;
                                            $fullyRestoredPercent = $totalDamageCount > 0 ? ($district->fully_restored / $totalDamageCount) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-success" style="width: {{ $fullyRestoredPercent }}%" title="Fully Restored: {{ $district->fully_restored }}"></div>
                                            <div class="progress-bar bg-warning" style="width: {{ $partiallyRestoredPercent }}%" title="Partially Restored: {{ $district->partially_restored }}"></div>
                                            <div class="progress-bar bg-danger" style="width: {{ $notRestoredPercent }}%" title="Not Restored: {{ $district->not_restored }}"></div>
                                        </div>
                                        <small class="d-flex justify-content-between mt-1">
                                            <span title="Fully Restored">FR: {{ $district->fully_restored }}</span>
                                            <span title="Partially Restored">PR: {{ $district->partially_restored }}</span>
                                            <span title="Not Restored">NR: {{ $district->not_restored }}</span>
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Top Restoration Costs</h5>
                </div>
                <div class="card-body">
                    <div id="costChart" style="height: 300px;"></div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Activity</h5>
                    <a href="{{ route('admin.apps.dmis.damages.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body scrollable-card">
                    <div class="activity-timeline">
                        @foreach($recentDamages as $damage)
                        <div class="timeline-item">
                            <h6 class="mb-1">{{ $damage?->infrastructure?->name }}</h6>
                            <p class="mb-0 small">
                                <span class="badge {{ $damage->damage_status == 'Fully Damaged' ? 'bg-danger' : 'bg-warning' }}">
                                    {{ $damage->damage_status }}
                                </span>
                                <span class="badge {{ $damage->road_status == 'Fully restored' ? 'bg-success' : ($damage->road_status == 'Partially restored' ? 'bg-info' : 'bg-danger') }}">
                                    {{ $damage->road_status }}
                                </span>
                                <span class="badge bg-secondary">{{ $damage->type }}</span>
                            </p>
                            <small class="text-muted">Reported by: {{ $damage->posting->user->name ?? 'Unknown' }}</small>
                            <br>
                            <small class="text-muted">{{ $damage->report_date->format('M d, Y') }} ({{ $damage->report_date->diffForHumans() }})</small>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Restoration Progress</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Fully Restored</span>
                            <span>{{ $fullyRestored }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" style="width: {{ $totalDamages > 0 ? ($fullyRestored / $totalDamages) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Partially Restored</span>
                            <span>{{ $partiallyRestored }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-info" style="width: {{ $totalDamages > 0 ? ($partiallyRestored / $totalDamages) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Not Restored</span>
                            <span>{{ $notRestored }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-danger" style="width: {{ $totalDamages > 0 ? ($notRestored / $totalDamages) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('admin/plugins/apexchart/apexcharts.min.js') }}"></script>
<script>
    // Store chart data in global scope for access by initDamageCharts
    window.chartData = {
        damageCounts: @json($damageCounts),
        months: @json($months),
        fullyDamaged: {{ $fullyDamaged }},
        partiallyDamaged: {{ $partiallyDamaged }},
        totalDamages: {{ $totalDamages }},
        fullyRestored: {{ $fullyRestored }},
        partiallyRestored: {{ $partiallyRestored }},
        notRestored: {{ $notRestored }},
        restorationCosts: [
            @foreach($highestRestorationCostDistricts as $district)
                {{ number_format($district->restoration_cost) }},
            @endforeach
        ],
        rehabilitationCosts: [
            @foreach($highestRestorationCostDistricts as $district)
                {{ number_format($district->rehabilitation_cost) }},
            @endforeach
        ],
        districtNames: [
            @foreach($highestRestorationCostDistricts as $district)
                '{{ $district->name }}',
            @endforeach
        ]
    };

    // If this script runs when page first loads (not via AJAX)
    if (typeof initDamageCharts === 'function') {
        initDamageCharts();
    } else {
        // Fallback: initialize charts directly if initDamageCharts is not available
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                if (typeof ApexCharts !== 'undefined') {
                    // Your existing chart initialization code here
                    const monthlyDamageOptions = {
                        series: [{
                            name: 'Damage Reports',
                            data: @json($damageCounts)
                        }],
                        chart: {
                            height: 300,
                            type: 'bar',
                            toolbar: {
                                show: false
                            }
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                dataLabels: {
                                    enabled: true,
                                    formatter: function(val) {
                                        return val;
                                    },
                                    offsetY: -20,
                                    style: {
                                        fontSize: '12px',
                                        colors: ["#304758"]
                                    }
                                }
                            }
                        },
                        xaxis: {
                            categories: @json($months),
                            position: 'bottom',
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            crosshairs: {
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        colorFrom: '#D8E3F0',
                                        colorTo: '#BED1E6',
                                        stops: [0, 100],
                                        opacityFrom: 0.4,
                                        opacityTo: 0.5,
                                    }
                                }
                            },
                            tooltip: {
                                enabled: true,
                            }
                        },
                        yaxis: {
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false,
                            },
                            labels: {
                                show: true,
                                formatter: function(val) {
                                    return val;
                                }
                            }
                        },
                        colors: ['#4e73df']
                    };

                    if (document.querySelector("#monthlyDamageChart")) {
                        const monthlyDamageChart = new ApexCharts(document.querySelector("#monthlyDamageChart"), monthlyDamageOptions);
                        monthlyDamageChart.render();
                    }

                    // Damage Status Chart
                    const damageStatusOptions = {
                        series: [{{ $fullyDamaged }}, {{ $partiallyDamaged }}],
                        chart: {
                            type: 'donut',
                            height: 250
                        },
                        labels: ['Fully Damaged', 'Partially Damaged'],
                        colors: ['#e74a3b', '#f6c23e'],
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '50%',
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            formatter: function(w) {
                                                return {{ $totalDamages }};
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

                    if (document.querySelector("#damageStatusChart")) {
                        const damageStatusChart = new ApexCharts(document.querySelector("#damageStatusChart"), damageStatusOptions);
                        damageStatusChart.render();
                    }

                    // Restoration Status Chart
                    const restorationStatusOptions = {
                        series: [{{ $fullyRestored }}, {{ $partiallyRestored }}, {{ $notRestored }}],
                        chart: {
                            type: 'donut',
                            height: 250
                        },
                        labels: ['Fully Restored', 'Partially Restored', 'Not Restored'],
                        colors: ['#1cc88a', '#36b9cc', '#e74a3b'],
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '50%',
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            formatter: function(w) {
                                                return {{ $totalDamages }};
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

                    if (document.querySelector("#restorationStatusChart")) {
                        const restorationStatusChart = new ApexCharts(document.querySelector("#restorationStatusChart"), restorationStatusOptions);
                        restorationStatusChart.render();
                    }

                    // Cost Chart
                    const costChartOptions = {
                        series: [{
                            name: 'Restoration Cost',
                            data: [
                                @foreach($highestRestorationCostDistricts as $district)
                                    {{ number_format($district->restoration_cost) }},
                                @endforeach
                            ]
                        }, {
                            name: 'Rehabilitation Cost',
                            data: [
                                @foreach($highestRestorationCostDistricts as $district)
                                    {{ number_format($district->rehabilitation_cost) }},
                                @endforeach
                            ]
                        }],
                        chart: {
                            type: 'bar',
                            height: 300,
                            stacked: true,
                            toolbar: {
                                show: false
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
                            categories: [
                                @foreach($highestRestorationCostDistricts as $district)
                                    '{{ $district->name }}',
                                @endforeach
                            ],
                            labels: {
                                formatter: function(val) {
                                    return val + "M";
                                }
                            }
                        },
                        yaxis: {
                            title: {
                                text: undefined
                            },
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " Million Rs.";
                                }
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'center',
                            offsetY: 0
                        },
                        colors: ['#4e73df', '#1cc88a']
                    };

                    if (document.querySelector("#costChart")) {
                        const costChart = new ApexCharts(document.querySelector("#costChart"), costChartOptions);
                        costChart.render();
                    }

                    // Initialize tooltips
                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                }
            }, 100);
        });
    }
</script>