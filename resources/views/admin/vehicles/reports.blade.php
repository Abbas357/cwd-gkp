<x-app-layout title="Vehicle Reports">
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
        .vehicle-details {
            line-height: 1.6;
        }
        .vehicle-details small {
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
            .no-print, .table-container {
                display: none;
            }
            body {
                font-size: 12pt;
            }
            table {
                page-break-inside: avoid;
            }
        }
    </style>
    @endpush
    
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Vehicle Reports</li>
    </x-slot>

    <div class="wrapper">
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="card-title mb-0">Vehicle Reports</h3>
            </div>
            <div class="card-body">
                <form method="GET" class="filter-section">
                    <div class="row g-3">

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="includeSubordinates" name="include_subordinates" value="1" @checked(request('include_subordinates'))>
                            <label class="form-check-label fw-bold" for="includeSubordinates">
                                Include Subordinates
                            </label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                    id="showHistory" name="show_history" value="1" 
                                    @checked(request('show_history'))>
                            <label class="form-check-label fw-bold" for="showHistory">
                                Include Past Allotments
                            </label>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="load-users">User / Office</label>
                            <select class="form-select form-select-md" data-placeholder="Choose" id="load-users" name="user_id">
                                @if(request('user_id'))
                                    <option value="{{ request('user_id') }}" selected>Loading...</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Vehicle Type</label>
                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                @foreach($cat['vehicle_type'] as $type)
                                    <option value="{{ $type->id }}" @selected(request('type') == $type->id)>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                @foreach($cat['vehicle_functional_status'] as $status)
                                    <option value="{{ $status->id }}" @selected(request('status') == $status->id)>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Specific Vehicle</label>
                            <select name="vehicle_id" class="form-select" data-placeholder="Select Vehicle">
                                <option value=""></option>
                                @foreach(App\Models\Vehicle::all() as $Vehicle)
                                    <option value="{{ $Vehicle->id }}" @selected($filters['vehicle_id'] == $Vehicle->id)>
                                        {{ $Vehicle->registration_number }} - {{ $Vehicle->brand }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <!-- Additional Filters -->
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Color</label>
                            <select name="color" class="form-select">
                                <option value="">All Colors</option>
                                @foreach($cat['vehicle_color'] as $color)
                                    <option value="{{ $color->name }}" @selected($filters['color'] == $color->name)>
                                        {{ $color->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Fuel Type</label>
                            <select name="fuel_type" class="form-select">
                                <option value="">All Fuel Types</option>
                                @foreach($cat['fuel_type'] as $fuel)
                                    <option value="{{ $fuel->name }}" @selected($filters['fuel_type'] == $fuel->name)>
                                        {{ $fuel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="cw-btn">
                                <i class="bi-filter me-1"></i> Generate Report
                            </button>
                            <a href="{{ route('admin.vehicles.reports') }}" class="btn btn-light">
                                <i class="bi-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <div class="table-container">
                    <button type="button" id="print-vehicle-details" class="no-print btn btn-light float-end me-2 m-2">
                        <span class="d-flex align-items-center">
                            <i class="bi-print"></i>
                            Print
                        </span>
                    </button>
                    <table class="table table-hover mb-0" id="vehicle-report">
                        <thead>
                            <tr>
                                <th class="bg-light">Vehicle Details</th>
                                <th class="bg-light">Registration</th>
                                <th class="bg-light">Alloted To</th>
                                <th class="bg-light">Status</th>
                                <th class="bg-light">Allotment Date</th>
                                @if(request('show_history'))
                                    <th class="bg-light">End Date</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allotments as $allotment)
                                <tr>
                                    <td>
                                        <div class="vehicle-details">
                                            <strong>{{ $allotment->vehicle->brand }} {{ $allotment->vehicle->model }}</strong>
                                            <small>Type: {{ $allotment->vehicle->type }}</small>
                                            <small>Color: {{ $allotment->vehicle->color }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="vehicle-details">
                                            <strong>{{ $allotment->vehicle->registration_number }}</strong>
                                            <small>Chassis: {{ $allotment->vehicle->chassis_number }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $allotment->user->position ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge bg-{{ $allotment->vehicle->functional_status === 'Active' ? 'success' : 'warning' }} text-white">
                                            {{ $allotment->vehicle->functional_status }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            {{ $allotment->start_date ? $allotment->start_date->format('j F, Y') : 'N/A' }}
                                        </span>
                                    </td>
                                    @if(request('show_history'))
                                    <td>
                                        <span class="text-muted">
                                            {{ $allotment->end_date ? $allotment->end_date->format('j F, Y') : 'Current' }}
                                        </span>
                                    </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p class="mb-0">No vehicles found matching the criteria</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script>
        $(document).ready(function() {
            const userSelect = $('#load-users');
            const selectedUserId = '{{ request('user_id') }}';
            const vehicleSelect = $('[name="vehicle_id"]');

            vehicleSelect.select2({
                theme: "bootstrap-5",
                placeholder: "Select Vehicle",
                allowClear: true,
                ajax: {
                    url: '{{ route("admin.vehicles.search") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return { q: params.term };
                    },
                    processResults: function(data) {
                        return { results: data };
                    }
                },
                templateResult: function(vehicle) {
                    return vehicle.text || vehicle.registration_number + ' - ' + vehicle.brand;
                }
            });
            userSelect.select2({
                theme: "bootstrap-5",
                placeholder: "Select User / Office",
                allowClear: true,
                ajax: {
                    url: '{{ route("admin.users.api") }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0,
                templateResult: function(user) {
                    if (user.loading) return user.text;
                    return user.position;
                },
                templateSelection: function(user) {
                    return user.position || 'Select User / Office'; // Fallback text
                }
            });

            if (selectedUserId) {
                $.ajax({
                    url: '{{ route("admin.users.api") }}',
                    data: {
                        id: selectedUserId
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.items && data.items.length > 0) {
                            const user = data.items[0];
                            const option = new Option(user.position, user.id, true, true);
                            userSelect.append(option).trigger('change');
                        }
                    }
                });
            }
        });

        $('#print-vehicle-details').on('click', () => {
            $("#vehicle-report").printThis({
                pageTitle: "Report",
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
</x-app-layout>