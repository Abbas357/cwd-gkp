<x-porms-layout title="Provincial Own Receipts Dashboard">
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
        .bg-light {
            background-color: #f0f0f0 !important; 
        }
    </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Provincial Own Receipts Dashboard</li>
    </x-slot>

    <div class="wrapper">
        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card card h-100" style="background: #0000ff15; border: 1px solid #0000ff20;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Receipts</h6>
                                <h3 class="mb-0">{{ number_format($totalAmount, 2) }}</h3>
                                <small class="text-muted">All receipts combined</small>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10">
                                <i class="bi bi-cash-stack text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card card h-100" style="background: #00ff0015; border: 1px solid #00ff0020;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Districts</h6>
                                <h3 class="mb-0">{{ $totalDistricts }}</h3>
                                <small class="text-success">Contributing districts</small>
                            </div>
                            <div class="stat-icon bg-success bg-opacity-10">
                                <i class="bi bi-geo-alt text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card card h-100" style="background: #ffd90015; border: 1px solid #ffd90020;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Types</h6>
                                <h3 class="mb-0">{{ $totalTypes }}</h3>
                                <small class="text-primary">Receipt categories</small>
                            </div>
                            <div class="stat-icon bg-warning bg-opacity-10">
                                <i class="bi bi-tags text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <!-- Type-based Analysis -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Receipts by Type</h5>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary active" data-period="6">6 Months</button>
                            <button class="btn btn-outline-secondary" data-period="12">1 Year</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="receiptsByTypeChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- District-based Analysis -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Top Districts by Revenue</h5>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary active" data-top="5">Top 5</button>
                            <button class="btn btn-outline-secondary" data-top="10">Top 10</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="receiptsByDistrictChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <!-- Monthly Trend -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Monthly Revenue Trend</h5>
                    </div>
                    <div class="card-body">
                        <div id="monthlyTrendChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- Type Distribution -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Receipt Type Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div id="typeDistributionChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Table -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">District & Type Breakdown</h5>
                        <button class="btn btn-sm btn-primary" id="exportData">
                            <i class="bi bi-download me-1"></i> Export Data
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>District</th>
                                        <th>Receipt Type</th>
                                        <th>Total Amount</th>
                                        <th>% of Total</th>
                                        <th>Entries</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($districtTypeBreakdown as $item)
                                    <tr>
                                        <td>{{ $item->district_name }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>{{ number_format($item->total_amount, 2) }}</td>
                                        <td>{{ number_format(($item->total_amount / $totalAmount) * 100, 1) }}%</td>
                                        <td>{{ $item->entry_count }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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

        // Receipts by Type Chart
        const typeData = @json($receiptsByType);
        const typeOptions = {
            series: [{
                name: 'Amount',
                data: typeData.map(item => parseFloat(item.total_amount))
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: typeData.map(item => item.type),
            },
            colors: ['#4e73df'],
            tooltip: {
                y: {
                    formatter: function(value) {
                        return value.toLocaleString('en-US', { 
                            style: 'currency', 
                            currency: 'PKR',
                            minimumFractionDigits: 2
                        });
                    }
                }
            }
        };

        new ApexCharts(document.querySelector("#receiptsByTypeChart"), typeOptions).render();

        // Receipts by District Chart
        const districtData = @json($receiptsByDistrict);
        const districtOptions = {
            series: [{
                name: 'Amount',
                data: districtData.slice(0, 5).map(item => parseFloat(item.total_amount))
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: districtData.slice(0, 5).map(item => item.district_name),
            },
            colors: ['#1cc88a'],
            tooltip: {
                y: {
                    formatter: function(value) {
                        return value.toLocaleString('en-US', { 
                            style: 'currency', 
                            currency: 'PKR',
                            minimumFractionDigits: 2
                        });
                    }
                }
            }
        };

        new ApexCharts(document.querySelector("#receiptsByDistrictChart"), districtOptions).render();

        // Monthly Trend Chart
        const monthlyData = @json($monthlyTrend);
        const monthlyOptions = {
            series: [{
                name: 'Revenue',
                data: monthlyData.map(item => parseFloat(item.total_amount))
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
                categories: monthlyData.map(item => item.month_label)
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
                        return value.toLocaleString('en-US', { 
                            style: 'currency', 
                            currency: 'PKR',
                            minimumFractionDigits: 2
                        });
                    }
                }
            }
        };

        new ApexCharts(document.querySelector("#monthlyTrendChart"), monthlyOptions).render();

        // Type Distribution Chart (Donut)
        const typeDistData = @json($receiptsByType);
        const typeDistOptions = {
            series: typeDistData.map(item => parseFloat(item.total_amount)),
            chart: {
                type: 'donut',
                height: 300
            },
            labels: typeDistData.map(item => item.type),
            colors: getColors(typeDistData.length),
            plotOptions: {
                pie: {
                    donut: {
                        size: '50%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                formatter: function(w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString('en-US', { 
                                        style: 'currency', 
                                        currency: 'PKR',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0
                                    });
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
            tooltip: {
                y: {
                    formatter: function(value) {
                        return value.toLocaleString('en-US', { 
                            style: 'currency', 
                            currency: 'PKR',
                            minimumFractionDigits: 2
                        });
                    }
                }
            }
        };

        new ApexCharts(document.querySelector("#typeDistributionChart"), typeDistOptions).render();

        // Handle period buttons
        document.querySelectorAll('[data-period]').forEach(button => {
            button.addEventListener('click', function() {
                const buttons = this.parentElement.querySelectorAll('.btn');
                buttons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Here you would update the chart with different period data
                // For example: updateTypeChart(this.dataset.period);
            });
        });

        // Handle top districts buttons
        document.querySelectorAll('[data-top]').forEach(button => {
            button.addEventListener('click', function() {
                const buttons = this.parentElement.querySelectorAll('.btn');
                buttons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                const topN = parseInt(this.dataset.top);
                const districtChart = ApexCharts.getChartByID('receiptsByDistrictChart');
                
                if (districtChart) {
                    districtChart.updateOptions({
                        series: [{
                            data: districtData.slice(0, topN).map(item => parseFloat(item.total_amount))
                        }],
                        xaxis: {
                            categories: districtData.slice(0, topN).map(item => item.district_name)
                        }
                    });
                }
            });
        });

        // Export data functionality
        document.getElementById('exportData').addEventListener('click', function() {
            // Add export functionality here
            alert('Export functionality would be implemented here');
        });
    </script>
    @endpush
</x-porms-layout>