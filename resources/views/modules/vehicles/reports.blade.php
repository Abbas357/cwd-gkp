<x-vehicle-layout title="Vehicle Reports">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --secondary-color: #f8f9fa;
            --border-radius: 0.5rem;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }
        
        .table > :not(caption) > * > * {
            vertical-align: middle;
            padding: 1rem;
        }
        
        .table th {
            background-color: #f0f4f8;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.6px;
            color: #495057;
            border-bottom: 2px solid #e9ecef;
        }
        
        .vehicle-details {
            line-height: 1.7;
        }
        
        .vehicle-details strong {
            font-size: 1.05rem;
            color: #212529;
        }
        
        .vehicle-details small {
            color: #6c757d;
            display: block;
            margin-top: 0.1rem;
            font-size: 0.8rem;
        }
        
        .status-badge {
            padding: 0.4em 0.8em;
            font-size: 0.75em;
            font-weight: 500;
            border-radius: 50rem;
            text-transform: capitalize;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .table-container {
            border: 1px solid #e9ecef;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }
        
        .table-container:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        .filter-section {
            background: linear-gradient(145deg, #f8f9fa, #ffffff);
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid #e9ecef;
        }
        
        /* Card and Button Enhancements */
        .card {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
        }
        
        .card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        .card-header {
            background: linear-gradient(to right, #e9ecef, #f8f9fa);
            border-bottom: 1px solid #e9ecef;
            padding: 1.25rem 1.5rem;
        }
        
        .card-title {
            font-weight: 700;
            color: #212529;
            margin: 0;
            font-size: 1.4rem;
        }
        
        .card-body {
            background: linear-gradient(to bottom, #ffffff, #fafbfc);
            padding: 2rem;
        }
        
        .cw-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: var(--transition);
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
        }
        
        .cw-btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3);
            color: white;
        }
        
        .btn {
            border-radius: var(--border-radius);
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn i {
            font-size: 1.1rem;
        }
        
        /* Form Enhancement */
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #495057;
            font-size: 0.9rem;
        }
        
        .form-control, .form-select {
            padding: 0.6rem 1rem;
            border: 1px solid #dee2e6;
            border-radius: var(--border-radius);
            transition: var(--transition);
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
        }
        
        .form-check-input {
            width: 1.2em;
            height: 1.2em;
            margin-top: 0.25em;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-switch .form-check-input {
            width: 2.5em;
        }
        
        /* Table Hover and Row Styles */
        .table-hover tbody tr {
            transition: var(--transition);
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
            transform: scale(1.005);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        tbody tr {
            border-bottom: 1px solid #e9ecef;
        }
        
        /* Empty State Enhancement */
        .empty-state {
            padding: 3rem;
            text-align: center;
        }
        
        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }
        
        .empty-state p {
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        /* Button Group Styling */
        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }
        
        /* Select2 Enhancement */
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: var(--border-radius);
            padding: 0.3rem 0.5rem;
            border: 1px solid #dee2e6;
            min-height: 42px;
        }
        
        .select2-container--bootstrap-5.select2-container--focus .select2-selection {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
        }
        
        /* Print Styling */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                font-size: 12pt;
            }
            
            table {
                page-break-inside: avoid;
            }
            
            .card, .table-container {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
            }
            
            .card-header {
                background: #f8f9fa !important;
            }
        }
    </style>
    @endpush
    
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Vehicle Reports</li>
    </x-slot>

    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Vehicle Reports</h3>
                    <span class="badge bg-primary rounded-pill">
                        {{ $allotments->count() }} {{ Str::plural('vehicle', $allotments->count()) }}
                    </span>
                </div>
            </div>
            <div class="card-body p-1">
                <div class="col-12 p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-muted mb-0 fs-5">Filter Options</h4>
                        <button type="button" id="toggleFilters" class="btn btn-sm btn-outline-secondary">
                            <i class="bi-chevron-up" id="filterIcon"></i>
                            <span id="filterText">Hide Filters</span>
                        </button>
                    </div>
                    <hr class="mt-2">
                </div>

                <form method="GET" class="filter-section">
                    <div class="row g-2">

                        <div class="d-flex align-items-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="includeSubordinates" name="include_subordinates" value="1" @checked(request('include_subordinates'))>
                                <label class="form-check-label" for="includeSubordinates">
                                    Include Subordinates
                                </label>
                            </div>
                            <div class="form-check form-switch ms-3">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                        id="showHistory" name="show_history" value="1" 
                                        @checked(request('show_history'))>
                                <label class="form-check-label" for="showHistory">
                                    Include Past Allotments
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="model_year">
                                Model Year
                            </label>
                            <input type="number" id="model_year" name="model_year" class="form-control" 
                                   placeholder="e.g. 2023" min="1900" max="{{ date('Y') + 1 }}" 
                                   value="{{ request('model_year') ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="load-users">
                                User / Office
                            </label>
                            <select name="user_id" id="load-users" class="form-select" data-placeholder="Select User / Office">
                                <option value=""></option>
                                @foreach(App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" @selected($filters['user_id'] == $user->id)>
                                        {{ $user->currentPosting?->office->name ?? '' }} - {{ $user->name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="vehicle_type">
                                Allotment Status
                            </label>
                            <select name="allotment_status" id="allotment_status" class="form-select">
                                <option value="">Allotment Status</option>
                                @foreach($cat['allotment_status'] as $allotment_status)
                                    <option value="{{ $allotment_status }}" @selected(request('allotment_status') == $allotment_status)>
                                        {{ $allotment_status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="vehicle_type">
                                Vehicle Type
                            </label>
                            <select name="type" id="vehicle_type" class="form-select">
                                <option value="">All Types</option>
                                @foreach($cat['vehicle_type'] as $type)
                                    <option value="{{ $type->id }}" @selected(request('type') == $type->id)>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="status">
                                Status
                            </label>
                            <select name="status" id="status" class="form-select">
                                <option value="">All Status</option>
                                @foreach($cat['vehicle_functional_status'] as $status)
                                    <option value="{{ $status->id }}" @selected(request('status') == $status->id)>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="registration_status">
                                Registration Status
                            </label>
                            <select name="registration_status" id="registration_status" class="form-select">
                                <option value="">All Registration Status</option>
                                @foreach($cat['vehicle_registration_status'] as $status)
                                    <option value="{{ $status->id }}" @selected(request('registration_status') == $status->id)>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="vehicle_id">
                                Specific Vehicle
                            </label>
                            <select name="vehicle_id" id="vehicle_id" class="form-select" data-placeholder="Select Vehicle">
                                <option value=""></option>
                                @foreach(App\Models\Vehicle::all() as $Vehicle)
                                    <option value="{{ $Vehicle->id }}" @selected($filters['vehicle_id'] == $Vehicle->id)>
                                        {{ $Vehicle->type }} - {{ $Vehicle->model }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <!-- Additional Filters -->
                        <div class="col-md-3">
                            <label class="form-label" for="color">
                                Color
                            </label>
                            <select name="color" id="color" class="form-select">
                                <option value="">All Colors</option>
                                @foreach($cat['vehicle_color'] as $color)
                                    <option value="{{ $color->name }}" @selected($filters['color'] == $color->name)>
                                        {{ $color->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="col-md-3">
                            <label class="form-label" for="fuel_type">
                                Fuel Type
                            </label>
                            <select name="fuel_type" id="fuel_type" class="form-select">
                                <option value="">All Fuel Types</option>
                                @foreach($cat['fuel_type'] as $fuel)
                                    <option value="{{ $fuel->name }}" @selected($filters['fuel_type'] == $fuel->name)>
                                        {{ $fuel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="col-md-3">
                            <label class="form-label" for="brand">
                                Brand
                            </label>
                            <select name="brand" id="brand" class="form-select">
                                <option value="">All Brands</option>
                                @foreach($cat['vehicle_brand'] as $brand)
                                    <option value="{{ $brand->id }}" @selected($filters['brand'] == $brand->id)>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <hr class="">
                            <div class="action-buttons">
                                <button type="submit" class="cw-btn">
                                    <i class="bi-filter me-2"></i> GENERATE REPORT
                                </button>
                                <a href="{{ route('admin.apps.vehicles.reports') }}" class="btn btn-sm px-3 border fs-6 py-1 btn-light">
                                    <i class="bi-arrow-counterclockwise me-2"></i> RESET FILTERS
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-container p-3">
                    <div class="d-flex justify-content-between align-items-center p-2 bg-light border-bottom">
                        <h5 class="m-0 fw-bold">Vehicle Allotment Results</h5>
                        <button type="button" id="print-vehicle-details" class="no-print btn btn-primary btn-sm">
                            <span class="d-flex align-items-center">
                                <i class="bi-printer me-2"></i>
                                Print Report
                            </span>
                        </button>
                    </div>
                    
                    <div class="d-flex p-4 justify-content-between align-items-center">
                        <div class="pagination-info">
                            @if(isset($totalCount))
                                <span class="badge bg-primary rounded-pill fs-6">
                                    {{ $totalCount }} {{ Str::plural('result', $totalCount) }} found
                                </span>
                            @endif
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <span class="me-2">Display:</span>
                            <select id="per-page-selector" class="form-select form-select-sm" style="width: auto;">
                                @foreach($paginationOptions as $value => $label)
                                    <option value="{{ $value }}" @selected($perPage == $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

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
                                <th class="bg-light no-print">Documents</th>
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
                                            <small>Year: {{ $allotment->vehicle->model_year ?? 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="vehicle-details">
                                            <strong>{{ $allotment->vehicle->registration_number }}</strong>
                                            <small>Chassis: {{ $allotment->vehicle->chassis_number }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium">
                                            @if ($allotment->user->currentPosting)
                                                {{ $allotment->user->name ?? '' . ' (' . $allotment->user->currentPosting->designation->name ?? '' . ')' }}<br>
                                                {{ 'at ' . $allotment->user->currentPosting->office->name ?? '' }}
                                            @else
                                                Pool
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge bg-{{ $allotment->vehicle->functional_status === 'Functional' ? 'success' : 'danger' }} text-white">
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
                                    @if($allotment->hasMedia('vehicle_allotment_orders'))
                                    <td class="no-print">
                                        <a href="{{ $allotment->getFirstMediaUrl('vehicle_allotment_orders') }}" 
                                           class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="bi-file-earmark-text me-1"></i> View Order
                                        </a>
                                    </td>
                                    @else
                                    <td class="no-print">
                                        <span class="badge bg-light text-secondary">Not Available</span>
                                    </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-state">
                                        <p>No vehicles found matching the criteria</p>
                                        <a href="{{ route('admin.apps.vehicles.reports') }}" class="btn btn-sm btn-outline-primary mt-2">
                                            RESET FILTERS
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="pagination-wrapper p-3 border-top d-flex justify-content-between align-items-center">
                        <div class="pagination-info">
                            @if(isset($allotments) && !($perPage === 'all') && $allotments instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                <span class="text-muted">
                                    Showing {{ $allotments->firstItem() ?? 0 }} to {{ $allotments->lastItem() ?? 0 }} of {{ $allotments->total() }} entries
                                </span>
                            @endif
                        </div>
                        
                        <div class="pagination-links">
                            @if(isset($allotments) && !($perPage === 'all') && $allotments instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ $allotments->links('pagination::bootstrap-5') }}
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script>
        $(document).ready(function() {

            const urlParams = new URLSearchParams(window.location.search);
            const hasRelevantParams = Array.from(urlParams.keys()).some(key => 
                key !== 'page' && key !== 'per_page'
            );
            
            const toggleFilters = () => {
                $('.filter-section').slideToggle(300);
                
                if ($('#filterIcon').hasClass('bi-chevron-up')) {
                    $('#filterIcon').removeClass('bi-chevron-up').addClass('bi-chevron-down');
                    $('#filterText').text('Show Filters');
                } else {
                    $('#filterIcon').removeClass('bi-chevron-down').addClass('bi-chevron-up');
                    $('#filterText').text('Hide Filters');
                }
            };
            
            if (hasRelevantParams) {
                $('.filter-section').hide();
                $('#filterIcon').removeClass('bi-chevron-up').addClass('bi-chevron-down');
                $('#filterText').text('Show Filters');
            }
            
            $('#toggleFilters').on('click', function() {
                toggleFilters();
            });

            $('#per-page-selector').on('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', $(this).val());
                window.location.href = url.toString();
            });
            
            $('.pagination .page-link').hover(
                function() { $(this).addClass('bg-light'); },
                function() { $(this).removeClass('bg-light'); }
            );

            const initSelect2 = (element, placeholder, url = null) => {
                const options = {
                    theme: "bootstrap-5",
                    dropdownParent: element.parent(),
                    placeholder: placeholder,
                    allowClear: true,
                    width: '100%'
                };
                
                if (url) {
                    options.ajax = {
                        url: url,
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
                                results: data.results || data,
                                pagination: {
                                    more: data.pagination ? data.pagination.more : false
                                }
                            };
                        },
                        cache: true
                    };
                    
                    options.templateResult = function(item) {
                        if (item.loading) {
                            return $('<div class="p-2"><i class="bi-hourglass-split me-2"></i>Loading...</div>');
                        }
                        return item.text;
                    };
                }
                
                element.select2(options);
                
                element.on('select2:open', function() {
                    $('.select2-container--open .select2-dropdown').addClass('animate__animated animate__fadeIn');
                    $('.select2-search__field').focus();
                });
            };

            initSelect2($('#load-users'), "Select User / Office", '{{ route("admin.apps.hr.users.api") }}');
            initSelect2($('[name="vehicle_id"]'), "Select Vehicle", '{{ route("admin.apps.vehicles.search") }}');
            
            $('select:not(#load-users):not([name="vehicle_id"])').each(function() {
                initSelect2($(this), $(this).find('option:first').text());
            });
            
            $('.form-control, .form-select').on('focus', function() {
                $(this).parent().find('.form-label').addClass('text-primary');
            }).on('blur', function() {
                $(this).parent().find('.form-label').removeClass('text-primary');
            });

            $('#print-vehicle-details').on('click', function() {
                Swal.fire({
                    title: 'Preparing Print View',
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                setTimeout(() => {
                    $("#vehicle-report").printThis({
                        pageTitle: "Vehicle Report - " + new Date().toLocaleDateString(),
                        importCSS: true,
                        importStyle: true,
                        loadCSS: "{{ asset('path/to/print.css') }}",
                        header: "<h1 class='text-center mb-4'>Vehicle Allotment Report</h1>" +
                                "<p class='text-center text-muted mb-4'>Generated on " + new Date().toLocaleDateString() + "</p>",
                        footer: "<p class='text-center mt-4'>&copy; " + new Date().getFullYear() + " - All Rights Reserved</p>",
                        beforePrint() {
                            $('.no-print').hide();
                        },
                        afterPrint() {
                            $('.no-print').show();
                            Swal.close();
                        }
                    });
                }, 500);
            });
            
            $('.card').addClass('animate__animated animate__fadeIn');
            $('.filter-section').addClass('animate__animated animate__fadeIn');
            $('.table-container').addClass('animate__animated animate__fadeIn');
        });
    </script>
    @endpush
</x-vehicle-layout>