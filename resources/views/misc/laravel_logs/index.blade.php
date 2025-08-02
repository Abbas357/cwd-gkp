<x-app-layout title="Laravel Logs" :showAside="false">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/chart.js/Chart.min.css') }}" rel="stylesheet">
    <style>
        .log-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            display: inline-block;
            width: 100%;
            text-align: center;
        }
        .log-emergency, .log-critical, .log-alert {
            background-color: #dc3545;
            color: white;
        }
        .log-error {
            background-color: #ff5722;
            color: white;
        }
        .log-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .log-notice, .log-info {
            background-color: #17a2b8;
            color: white;
        }
        .log-debug {
            background-color: #6c757d;
            color: white;
        }
        .stats-card {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: transform 0.2s;
            height: 100%;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-icon {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .stats-value {
            font-size: 24px;
            font-weight: bold;
        }
        .error-stats {
            background-color: #ff5722;
            color: white;
        }
        .warning-stats {
            background-color: #ffc107;
            color: #212529;
        }
        .info-stats {
            background-color: #17a2b8;
            color: white;
        }
        .total-stats {
            background-color: #6610f2;
            color: white;
        }
        .today-stats {
            background-color: #28a745;
            color: white;
        }
        .critical-stats {
            background-color: #dc3545;
            color: white;
        }
        .emergency-stats {
            background-color: #9c0000;
            color: white;
        }
        .notice-stats {
            background-color: #0dcaf0;
            color: white;
        }
        .debug-stats {
            background-color: #6c757d;
            color: white;
        }
        .message-truncate {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .btn-manage {
            margin-right: 5px;
        }
        .log-file-table {
            margin-bottom: 30px;
        }
        .common-error-item {
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 6px;
            background-color: rgba(255, 87, 34, 0.1);
            border-left: 4px solid #ff5722;
        }
        .common-error-count {
            font-weight: bold;
            background-color: #ff5722;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            margin-right: 10px;
        }
        .error-message {
            font-family: monospace;
            font-size: 13px;
            color: #333;
        }
        .chart-container {
            position: relative;
            height: 250px;
            margin-bottom: 30px;
        }
        .view-btn {
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 4px;
            margin-right: 5px;
            transition: all 0.2s;
        }
        .view-btn:hover {
            background-color: #e9ecef;
        }
        .stack-trace-container {
            position: relative;
        }
        .copy-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(255,255,255,0.3);
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            color: white;
            cursor: pointer;
        }
        .copy-btn:hover {
            background-color: rgba(255,255,255,0.5);
        }
        .log-entry-row {
            transition: all 0.2s;
        }
        .log-entry-row:hover {
            background-color: rgba(0,0,0,0.03) !important;
        }
        .log-entry-row td {
            vertical-align: middle;
        }
        .log-entry-time {
            font-size: 12px;
            color: #6c757d;
            display: block;
        }
        .action-btns {
            display: flex;
            justify-content: center;
        }
    </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Laravel Logs</li>
    </x-slot>

    <!-- Stats Dashboard -->
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Log Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-lg-3">
                            <div class="stats-card total-stats">
                                <div class="stats-icon">
                                    <i class="bi bi-list-ul"></i>
                                </div>
                                <div class="stats-title">Total Logs</div>
                                <div class="stats-value">{{ $stats['total'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="stats-card error-stats">
                                <div class="stats-icon">
                                    <i class="bi bi-exclamation-octagon"></i>
                                </div>
                                <div class="stats-title">Errors</div>
                                <div class="stats-value">{{ $stats['errors'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="stats-card warning-stats">
                                <div class="stats-icon">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </div>
                                <div class="stats-title">Warnings</div>
                                <div class="stats-value">{{ $stats['warnings'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="stats-card info-stats">
                                <div class="stats-icon">
                                    <i class="bi bi-info-circle"></i>
                                </div>
                                <div class="stats-title">Info</div>
                                <div class="stats-value">{{ $stats['info'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="stats-card critical-stats">
                                <div class="stats-icon">
                                    <i class="bi bi-exclamation-diamond"></i>
                                </div>
                                <div class="stats-title">Critical</div>
                                <div class="stats-value">{{ $stats['critical'] }}</div>
                            </div>
                        </div>
                        <!-- Fix for the emergency stats in the blade view -->
                        <div class="col-md-4 col-lg-3">
                            <div class="stats-card emergency-stats">
                                <div class="stats-icon">
                                    <i class="bi bi-exclamation-octagon-fill"></i>
                                </div>
                                <div class="stats-title">Emergency</div>
                                <div class="stats-value">{{ $stats['emergency'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="stats-card notice-stats">
                                <div class="stats-icon">
                                    <i class="bi bi-info-square"></i>
                                </div>
                                <div class="stats-title">Notice</div>
                                <div class="stats-value">{{ $stats['notice'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="stats-card debug-stats">
                                <div class="stats-icon">
                                    <i class="bi bi-bug"></i>
                                </div>
                                <div class="stats-title">Debug</div>
                                <div class="stats-value">{{ $stats['debug'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Common Errors -->
    <div class="row mb-4">
        <!-- Log Trend Chart -->
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="card-title">Log Trends (Last 7 Days)</h4>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="logTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Most Common Errors -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="card-title">Most Common Errors</h4>
                </div>
                <div class="card-body">
                    @if(count($stats['common_errors']) > 0)
                        @foreach($stats['common_errors'] as $error => $count)
                            <div class="common-error-item">
                                <span class="common-error-count">{{ $count }}</span>
                                <span class="error-message">{{ $error }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-3">
                            <i class="bi bi-emoji-smile fs-3"></i>
                            <p class="mt-2">No errors found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Log Files Management -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Log Files</h4>
            <div>
                <button id="refresh-files" class="btn btn-sm btn-primary">
                    <i class="bi bi-arrow-clockwise"></i> Refresh
                </button>
                <button id="clear-logs" class="btn btn-sm btn-danger">
                    <i class="bi bi-trash"></i> Clear All Logs
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive log-file-table">
                <table id="log-files-table" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Filename</th>
                            <th>Size</th>
                            <th>Last Modified</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Log files will be loaded here via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Log Entries -->
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Log Entries</h4>
            <div class="log-filter">
                <select id="log-level-filter" class="form-select form-select-sm">
                    <option value="">All Levels</option>
                    <option value="error">Error</option>
                    <option value="warning">Warning</option>
                    <option value="info">Info</option>
                    <option value="debug">Debug</option>
                    <option value="critical">Critical</option>
                    <option value="emergency">Emergency</option>
                    <option value="alert">Alert</option>
                    <option value="notice">Notice</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="log-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
                    <thead>
                        <tr>
                            <th scope="col" class="p-3">ID</th>
                            <th scope="col" class="p-3">Level</th>
                            <th scope="col" class="p-3">Message</th>
                            <th scope="col" class="p-3">File</th>
                            <th scope="col" class="p-3">Line</th>
                            <th scope="col" class="p-3">Details</th>
                            <th scope="col" class="p-3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/col-resizable.js') }}"></script>
    <script src="{{ asset('admin/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Log Entries DataTable
            var table = initDataTable('#log-datatable', {
                ajaxUrl: "{{ route('admin.settings.logs.index') }}",
                columns: [
                    { data: 'id', searchBuilderType: "num" },
                    { data: 'level', searchBuilderType: 'string' },
                    { data: 'message', searchBuilderType: 'string' },
                    { data: 'file', searchBuilderType: 'string' },
                    { data: 'line', searchBuilderType: 'num' },
                    { data: 'stack', searchBuilderType: 'string', orderable: false, searchable: false },
                    { data: 'date', searchBuilderType: 'date' }
                ],
                defaultOrderColumn: 6,
                defaultOrderDirection: 'desc',
                columnDefs: [{
                    targets: [0],
                    visible: false
                }],
                pageLength: 10,
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('log-entry-row');
                    
                    // Add styling based on log level
                    const level = data.level.toLowerCase();
                    if (level === 'error' || level === 'critical' || level === 'emergency') {
                        $(row).css('background-color', 'rgba(255, 87, 34, 0.05)');
                    } else if (level === 'warning') {
                        $(row).css('background-color', 'rgba(255, 193, 7, 0.05)');
                    }
                }
            });
            
            // Log level filter
            $('#log-level-filter').on('change', function() {
                const level = $(this).val();
                table.column(1).search(level).draw();
            });
            
            // Load log files
            loadLogFiles();
            
            // Initialize trend chart
            initLogTrendChart();
            
            // Refresh log files button
            $('#refresh-files').on('click', function() {
                loadLogFiles();
            });
            
            // Clear all logs button
            $('#clear-logs').on('click', function() {
                if (confirm('Are you sure you want to clear all log files? This action cannot be undone.')) {
                    $.ajax({
                        url: "{{ route('admin.settings.logs.clear') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            toastr.success('All log files cleared successfully.');
                            loadLogFiles();
                            table.ajax.reload();
                        },
                        error: function(error) {
                            toastr.error('Failed to clear log files.');
                        }
                    });
                }
            });
            
            // Function to load log files
            function loadLogFiles() {
                $.ajax({
                    url: "{{ route('admin.settings.logs.files') }}",
                    type: 'GET',
                    success: function(response) {
                        var filesTable = $('#log-files-table tbody');
                        filesTable.empty();
                        
                        if (response.files.length === 0) {
                            filesTable.append('<tr><td colspan="4" class="text-center">No log files found.</td></tr>');
                            return;
                        }
                        
                        $.each(response.files, function(index, file) {
                            var row = $('<tr></tr>');
                            row.append('<td>' + file.name + '</td>');
                            row.append('<td>' + file.size + '</td>');
                            row.append('<td>' + file.modified + '</td>');
                            
                            var actions = $('<td></td>');
                            var downloadBtn = $('<a href="{{ route('admin.settings.logs.download', '') }}/' + file.name + '" class="btn btn-sm btn-info btn-manage"><i class="bi bi-download"></i> Download</a>');
                            var deleteBtn = $('<button class="btn btn-sm btn-danger btn-manage delete-log" data-file="' + file.name + '"><i class="bi bi-trash"></i> Delete</button>');
                            var viewBtn = $('<button class="btn btn-sm btn-primary btn-manage view-log" data-file="' + file.name + '"><i class="bi bi-eye"></i> View</button>');
                            
                            actions.append(viewBtn);
                            actions.append(downloadBtn);
                            actions.append(deleteBtn);
                            row.append(actions);
                            
                            filesTable.append(row);
                        });
                        
                        // Add delete event handlers
                        $('.delete-log').on('click', function() {
                            var filename = $(this).data('file');
                            if (confirm('Are you sure you want to delete this log file?')) {
                                $.ajax({
                                    url: "{{ route('admin.settings.logs.delete', '') }}/" + filename,
                                    type: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        toastr.success('Log file deleted successfully.');
                                        loadLogFiles();
                                        table.ajax.reload();
                                    },
                                    error: function(error) {
                                        toastr.error('Failed to delete log file.');
                                    }
                                });
                            }
                        });
                        
                        // Add view event handlers
                        $('.view-log').on('click', function() {
                            var filename = $(this).data('file');
                            table.ajax.url("{{ route('admin.settings.logs.index') }}?file=" + filename).load();
                        });
                    },
                    error: function(error) {
                        toastr.error('Failed to load log files.');
                    }
                });
            }
            
            // Initialize trend chart
            function initLogTrendChart() {
                const ctx = document.getElementById('logTrendChart').getContext('2d');
                
                const trendData = @json($stats['error_trend'] ?? []);
                const dates = Object.keys(trendData);
                const errorData = dates.map(date => trendData[date].errors);
                const warningData = dates.map(date => trendData[date].warnings);
                const infoData = dates.map(date => trendData[date].info);
                const otherData = dates.map(date => trendData[date].other);
                
                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: dates.map(date => {
                            const d = new Date(date);
                            return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                        }),
                        datasets: [
                            {
                                label: 'Errors',
                                data: errorData,
                                backgroundColor: '#ff5722',
                                borderColor: '#ff5722',
                                borderWidth: 1
                            },
                            {
                                label: 'Warnings',
                                data: warningData,
                                backgroundColor: '#ffc107',
                                borderColor: '#ffc107',
                                borderWidth: 1
                            },
                            {
                                label: 'Info',
                                data: infoData,
                                backgroundColor: '#17a2b8',
                                borderColor: '#17a2b8',
                                borderWidth: 1
                            },
                            {
                                label: 'Other',
                                data: otherData,
                                backgroundColor: '#6c757d',
                                borderColor: '#6c757d',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        }
                    }
                });
            }
            
            // Copy stack trace function
            window.copyStackTrace = function(id) {
                const stackElem = document.getElementById('stack-content-' + id);
                navigator.clipboard.writeText(stackElem.textContent).then(function() {
                    toastr.success('Stack trace copied to clipboard');
                }, function() {
                    toastr.error('Failed to copy stack trace');
                });
            }
        });
    </script>
    @endpush
</x-app-layout>