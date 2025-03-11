<x-porms-layout title="Provincial Own Receipts Reports">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <style>
        /* General Table and Layout Styles */
        .table > :not(caption) > * > * {
            vertical-align: middle;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        .receipt-details {
            line-height: 1.6;
        }
        .receipt-details small {
            color: #6c757d;
            display: block;
        }
        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 500;
            border-radius: 0.25rem;
            text-transform: capitalize;
        }
        .table-container {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .filter-section {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        /* Enhanced Styles */
        .card-header {
            background-color: #e9ecef; /* Lighter grey */
        }
        .card-body {
            background: linear-gradient(to bottom, #ffffff, #f8f9fa); /* Very subtle gradient */
        }
        .cw-btn, .btn {
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .cw-btn:hover, .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        /* Print Styling */
        @media print {
            .no-print {
                display: none;
            }
            body {
                font-size: 12pt;
            }
            table {
                page-break-inside: avoid;
            }
        }
        .amount-cell {
            text-align: right;
            font-family: monospace;
            font-weight: 500;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: 600;
        }
    </style>
    @endpush
    
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Provincial Own Receipts Reports</li>
    </x-slot>

    <div class="wrapper">
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="card-title mb-0">Provincial Own Receipts Reports</h3>
            </div>
            <div class="card-body">
                <form method="GET" class="filter-section">
                    <div class="row g-3">
                        <!-- Date Range Filter -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Month Range</label>
                            <div class="input-group">
                                <input type="month" name="start_month" class="form-control" value="{{ request('start_month') }}" placeholder="From">
                                <span class="input-group-text">to</span>
                                <input type="month" name="end_month" class="form-control" value="{{ request('end_month') }}" placeholder="To">
                            </div>
                        </div>
                        
                        <!-- District Filter -->
                        <div class="col-md-3">
                            <label class="form-label fw-bold">District</label>
                            <select name="district_id" class="form-select">
                                <option value="">All Districts</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" @selected(request('district_id') == $district->id)>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type Filter -->
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Receipt Type</label>
                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                @foreach($receiptTypes as $type)
                                    <option value="{{ $type }}" @selected(request('type') == $type)>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- DDO Code Filter -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">DDO Code</label>
                            <select name="ddo_code" class="form-select" data-placeholder="Select DDO Code">
                                <option value="">All DDO Codes</option>
                                @foreach($ddoCodes as $code)
                                    <option value="{{ $code }}" @selected(request('ddo_code') == $code)>
                                        {{ $code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- User Filter -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="load-users">User</label>
                            <select name="user_id" id="load-users" class="form-select" data-placeholder="Select User">
                                <option value=""></option>
                                @foreach(App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" @selected($filters['user_id'] == $user->id)>
                                        {{ $user->position }} - {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="cw-btn">
                                <i class="bi-filter me-1"></i> Generate Report
                            </button>
                            <a href="{{ route('admin.apps.porms.report') }}" class="btn btn-light">
                                <i class="bi-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <div class="table-container">
                    <div class="d-flex justify-content-between align-items-center px-3 py-2 bg-light">
                        <h5 class="mb-0">Summary: {{ $receipts->count() }} records found</h5>
                        <button type="button" id="print-receipts" class="no-print btn btn-light">
                            <span class="d-flex align-items-center">
                                <i class="bi-print me-1"></i>
                                Print
                            </span>
                        </button>
                    </div>
                    <table class="table table-hover mb-0" id="receipts-report">
                        <thead>
                            <tr>
                                <th class="bg-light">Month</th>
                                <th class="bg-light">District</th>
                                <th class="bg-light">DDO Code</th>
                                <th class="bg-light">Type</th>
                                <th class="bg-light">Amount (PKR)</th>
                                <th class="bg-light">Submitted By</th>
                                <th class="bg-light">Remarks</th>
                                <th class="bg-light no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($receipts as $receipt)
                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::parse($receipt->month)->format('F Y') }}
                                    </td>
                                    <td>
                                        {{ $receipt->district->name }}
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $receipt->ddo_code }}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge bg-info text-white">
                                            {{ $receipt->type }}
                                        </span>
                                    </td>
                                    <td class="amount-cell">
                                        {{ number_format($receipt->amount, 2) }}
                                    </td>
                                    <td>
                                        {{ $receipt->user->name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $receipt->remarks ?? 'No remarks' }}</small>
                                    </td>
                                    <td class="no-print">
                                        <a href="{{ route('admin.apps.porms.show', $receipt) }}" class="btn btn-sm btn-light">
                                            <i class="bi-eye"></
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p class="mb-0">No receipts found matching the criteria</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            @if($receipts->count() > 0)
                                <tr class="total-row">
                                    <td colspan="4" class="text-end">Total Amount:</td>
                                    <td class="amount-cell">{{ number_format($receipts->sum('amount'), 2) }}</td>
                                    <td colspan="3"></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <!-- Summary Statistics Cards -->
                @if($receipts->count() > 0)
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Receipts</h5>
                                <h2 class="card-text text-primary">PKR {{ number_format($receipts->sum('amount'), 2) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">By Type</h5>
                                <div class="mt-3">
                                    @foreach($receiptSummaryByType as $type => $amount)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ $type }}:</span>
                                        <span class="fw-bold">PKR {{ number_format($amount, 2) }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">By District</h5>
                                <div class="mt-3">
                                    @foreach($receiptSummaryByDistrict as $district => $amount)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ $district }}:</span>
                                        <span class="fw-bold">PKR {{ number_format($amount, 2) }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script>
        $(document).ready(function() {
            const userSelect = $('#load-users');
            
            userSelect.select2({
                theme: "bootstrap-5",
                dropdownParent: $('#load-users').parent(),
                placeholder: "Select User",
                allowClear: true,
                ajax: {
                    url: '{{ route("admin.apps.hr.users.api") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                },
                templateResult: function(user) {
                    if (user.loading) {
                        return 'Loading...';
                    }
                    return user.text;
                },
                templateSelection: function(user) {
                    return user.text || 'Select User';
                }
            });
        });

        $('#print-receipts').on('click', () => {
            $("#receipts-report").printThis({
                pageTitle: "Provincial Own Receipts Report",
                beforePrint() {
                    document.querySelector('.page-loader').classList.remove('hidden');
                },
                afterPrint() {
                    document.querySelector('.page-loader').classList.add('hidden');
                }
            });
        });
    </script>
    @endpush
</x-porms-layout>9