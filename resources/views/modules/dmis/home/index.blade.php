<x-dmis-layout title="DMIS Dashboard">
    @push('style')
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
        [data-bs-theme=dark] .bg-light {
            background-color: #2a2a2a !important; 
        }
        .district-badge {
            font-size: 0.9rem;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }
        [data-bs-theme=dark] .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
        .district-name {
            font-size: 1rem;
            font-weight: 500;
        }
        .scrollable-card {
            max-height: 350px;
            overflow-y: auto;
        }
        .progress {
            height: 8px;
            margin-top: 5px;
        }
        .filter-section {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </x-slot>

    <div class="row filter-section">
        <div class="col-md-4">
            <label for="type" class="form-label">Infrastructure Type</label>
            <select name="type" id="type" class="form-select">
                @foreach(setting('infrastructure_type', 'dmis') as $infraType)
                    <option value="{{ $infraType }}">{{ $infraType }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="col-md-4">
            <label for="from_date" class="form-label">From Date</label>
            <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>
    
        <div class="col-md-4">
            <label for="to_date" class="form-label">To Date</label>
            <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>
    </div>


   <section id="main">
        <x-dashboard-skeleton 
            :table-rows="3" 
            :table-columns="5"
            loading-text="Loading Analytics..."
            :show-stats-boxes="true"
            :show-table="true" 
            :show-charts="true"
        />
   </section>

    @push('script')
    <script>
        // Add this function to your main dashboard view (paste.txt)
// Replace the existing script section with this updated version

$(document).ready(function() {
    loadMainReport();

    // Listen for changes on any filter input
    $('#type, #from_date, #to_date').on('change', function(e) {
        loadMainReport();
    });

    // Add debouncing to prevent too many requests
    let debounceTimer;
    $('#from_date, #to_date').on('input', function(e) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function() {
            loadMainReport();
        }, 500); // Wait 500ms after user stops typing
    });

    async function loadMainReport() {
        try {
            // Show loading skeleton
            $('#main').html(`
                <x-dashboard-skeleton 
                    :table-rows="3" 
                    :table-columns="5"
                    loading-text="Loading Analytics..."
                    :show-stats-boxes="true"
                    :show-table="true" 
                    :show-charts="true"
                />
            `);

            const type = $('#type').val() || "Road";
            const fromDate = $('#from_date').val();
            const toDate = $('#to_date').val();

            const url = "{{ route('admin.apps.dmis.dashboard') }}";

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    'type': type,
                    'from_date': fromDate,
                    'to_date': toDate,
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success && data.data && data.data.result) {
                $('#main').html(data.data.result);
                // Initialize charts after content is loaded
                initDamageCharts();
            } else {
                $('#main').html(
                    '<div class="alert alert-warning" role="alert">' +
                    '<i class="bi-exclamation-triangle me-2"></i>' +
                    'No data available for the selected criteria.' +
                    '</div>'
                );
            }
        } catch (error) {
            console.error('Error loading report:', error);
            $('#main').html(
                '<div class="alert alert-danger" role="alert">' +
                '<i class="bi-exclamation-circle me-2"></i>' +
                'Error loading dashboard report. Please try again later.' +
                '</div>'
            );
        }
    }

    // Define the initDamageCharts function
    window.initDamageCharts = function() {
        // Wait a bit for DOM to be ready
        setTimeout(function() {
            // Check if ApexCharts is loaded
            if (typeof ApexCharts === 'undefined') {
                console.error('ApexCharts is not loaded');
                return;
            }

            // Monthly Damage Chart
            if (document.querySelector("#monthlyDamageChart")) {
                // Get data from the loaded HTML
                const monthlyData = window.chartData || {};
                
                const monthlyDamageOptions = {
                    series: [{
                        name: 'Damage Reports',
                        data: monthlyData.damageCounts || []
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
                        categories: monthlyData.months || [],
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

                const monthlyDamageChart = new ApexCharts(document.querySelector("#monthlyDamageChart"), monthlyDamageOptions);
                monthlyDamageChart.render();
            }

            // Damage Status Chart
            if (document.querySelector("#damageStatusChart")) {
                const damageStatusOptions = {
                    series: [
                        window.chartData?.fullyDamaged || 0,
                        window.chartData?.partiallyDamaged || 0
                    ],
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
                                            return window.chartData?.totalDamages || 0;
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

                const damageStatusChart = new ApexCharts(document.querySelector("#damageStatusChart"), damageStatusOptions);
                damageStatusChart.render();
            }

            // Restoration Status Chart
            if (document.querySelector("#restorationStatusChart")) {
                const restorationStatusOptions = {
                    series: [
                        window.chartData?.fullyRestored || 0,
                        window.chartData?.partiallyRestored || 0,
                        window.chartData?.notRestored || 0
                    ],
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
                                            return window.chartData?.totalDamages || 0;
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

                const restorationStatusChart = new ApexCharts(document.querySelector("#restorationStatusChart"), restorationStatusOptions);
                restorationStatusChart.render();
            }

            // Cost Chart
            if (document.querySelector("#costChart")) {
                const costChartOptions = {
                    series: [{
                        name: 'Restoration Cost',
                        data: window.chartData?.restorationCosts || []
                    }, {
                        name: 'Rehabilitation Cost',
                        data: window.chartData?.rehabilitationCosts || []
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
                        categories: window.chartData?.districtNames || [],
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

                const costChart = new ApexCharts(document.querySelector("#costChart"), costChartOptions);
                costChart.render();
            }

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            console.log('Charts initialized successfully');
        }, 100);
    };
});
    </script>
    @endpush
</x-dmis-layout>