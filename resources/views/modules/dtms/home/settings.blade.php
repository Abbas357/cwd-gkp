<x-dtms-layout title="Damage Tracking System Settings">
    @push('style')
        <style>
            .nav-tabs .settings-tab {
                padding: 12px 15px;
                margin-bottom: 5px;
                border-radius: 8px;
                transition: all 0.3s ease;
                color: #555;
                border: 1px solid transparent;
                background-color: #f8f9fa;
                text-align: left;
            }

            .nav-tabs .settings-tab:hover {
                background-color: #e9ecef;
                transform: translateX(5px);
                color: #333;
            }

            .nav-tabs .settings-tab.active {
                background-color: #0d6efd;
                color: white;
                border-color: #0d6efd;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .nav-tabs .settings-tab .bi {
                transition: all 0.3s ease;
            }

            .nav-tabs .settings-tab:hover .bi {
                transform: scale(1.2);
            }

            .card {
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
            }

            .card:hover {
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            }

            .card-header {
                background-color: #f8f9fa;
                border-bottom: 1px solid rgba(0,0,0,.05);
            }

            .category-table {
                border-radius: 8px;
                overflow: hidden;
            }

            .category-table thead th {
                background-color: #f1f3f5;
                border-bottom: 2px solid #dee2e6;
            }

            .category-table .form-control {
                border-radius: 6px;
                transition: all 0.2s ease;
            }

            .category-table .form-control:focus {
                box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
            }

            .btn {
                border-radius: 6px;
                transition: all 0.2s ease;
            }

            .btn:hover {
                transform: translateY(-2px);
            }

            .btn-success {
                background-color: #198754;
                border-color: #198754;
            }

            .btn-danger {
                background-color: #dc3545;
                border-color: #dc3545;
            }

            .btn-warning {
                color: #212529;
            }

            .tab-pane {
                animation: fadeIn 0.3s ease;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .tab-content {
                background-color: white;
                border-radius: 10px;
            }

            @media (max-width: 768px) {
                .nav-tabs .settings-tab {
                    width: 100%;
                    text-align: left;
                }
                
                .col-md-3, .col-md-9 {
                    padding: 0 5px;
                }
            }
        </style>
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.dtms.dashboard') }}">Damage Tracking System</a></li>
        <li class="breadcrumb-item active" aria-current="page">Settings</li>
    </x-slot>

    <div class="container-fluid">
        <div class="row">
            <!-- Left Navigation - Tabs -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Settings</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="nav flex-column nav-tabs" id="settings-tabs" role="tablist">
                            <button class="nav-link settings-tab active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                                <i class="bi bi-gear me-2"></i> General Settings
                            </button>
                            <button class="nav-link settings-tab" id="road-status-tab" data-bs-toggle="tab" data-bs-target="#road-status" type="button" role="tab" aria-controls="road-status" aria-selected="false">
                                <i class="bi bi-signpost me-2"></i> Road Status
                            </button>
                            <button class="nav-link settings-tab" id="infrastructure-type-tab" data-bs-toggle="tab" data-bs-target="#infrastructure-type" type="button" role="tab" aria-controls="infrastructure-type" aria-selected="false">
                                <i class="bi bi-building me-2"></i> Infrastructure Types
                            </button>
                            <button class="nav-link settings-tab" id="damage-status-tab" data-bs-toggle="tab" data-bs-target="#damage-status" type="button" role="tab" aria-controls="damage-status" aria-selected="false">
                                <i class="bi bi-exclamation-triangle me-2"></i> Damage Status
                            </button>
                            <button class="nav-link settings-tab" id="damage-nature-tab" data-bs-toggle="tab" data-bs-target="#damage-nature" type="button" role="tab" aria-controls="damage-nature" aria-selected="false">
                                <i class="bi bi-list-check me-2"></i> Damage Nature
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <form action="{{ route('admin.apps.dtms.settings.init') }}" method="POST" onsubmit="return confirm('This will reset all settings to default values. Continue?');">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="bi bi-arrow-clockwise me-1"></i> Reset to Defaults
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content - Tab Contents -->
            <div class="col-md-9">
                <form id="settingsForm" action="{{ route('admin.apps.dtms.settings.update') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="tab-content">
                        <!-- General Settings -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">General Settings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Activity</label>
                                        <select class="form-select @error('activity') is-invalid @enderror" name="settings[activity][value]" placeholder="Activity" required>
                                            <option value="">All Activities</option>
                                            @foreach($activityTypes as $type)
                                                <option value="{{ $type }}" @selected(setting('activity', 'dtms') == $type)>
                                                    {{ $type }}
                                                </option>
                                            @endforeach
                                        </select>                                        
                                        @error('settings.activity.value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="session" class="form-label">Session</label>
                                        <select class="form-select @error('session') is-invalid @enderror" name="settings[session][value]" placeholder="Session" required>
                                            <option value="">All Years</option>
                                            @foreach($years as $year)
                                                <option value="{{ $year }}" @selected(setting('session', 'dtms') == $year)>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('settings.session.value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Road Status Category -->
                        <div class="tab-pane fade" id="road-status" role="tabpanel" aria-labelledby="road-status-tab">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Road Status</h5>
                                </div>
                                <div class="card-body">
                                    <div class="category-container" data-category-key="road_status">
                                        <p class="text-muted mb-3">Define the possible status values for roads in the system.</p>
                                        
                                        <input type="hidden" name="categories[road_status][description]" value="Types of Road Status">
                                        <input type="hidden" name="categories[road_status][type]" value="category">
                                        
                                        <div class="mb-3">
                                            <div class="table-responsive">
                                                <table class="table table-bordered category-table">
                                                    <thead>
                                                        <tr>
                                                            <th width="90%">Status</th>
                                                            <th width="10%">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach(category('road_status', 'dtms', []) as $index => $item)
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control" 
                                                                        name="categories[road_status][value][]" 
                                                                        value="{{ $item }}" required>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-sm btn-danger remove-item">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr class="new-item-row">
                                                            <td>
                                                                <input type="text" class="form-control new-item" placeholder="Add new status...">
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-success add-item">
                                                                    <i class="bi bi-plus-circle"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Infrastructure Type Category -->
                        <div class="tab-pane fade" id="infrastructure-type" role="tabpanel" aria-labelledby="infrastructure-type-tab">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Infrastructure Types</h5>
                                </div>
                                <div class="card-body">
                                    <div class="category-container" data-category-key="infrastructure_type">
                                        <p class="text-muted mb-3">Define the types of infrastructure in the system.</p>
                                        
                                        <input type="hidden" name="categories[infrastructure_type][description]" value="Types of Infrastructures">
                                        <input type="hidden" name="categories[infrastructure_type][type]" value="category">
                                        
                                        <div class="mb-3">
                                            <div class="table-responsive">
                                                <table class="table table-bordered category-table">
                                                    <thead>
                                                        <tr>
                                                            <th width="90%">Type</th>
                                                            <th width="10%">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach(category('infrastructure_type', 'dtms', []) as $index => $item)
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control" 
                                                                        name="categories[infrastructure_type][value][]" 
                                                                        value="{{ $item }}" required>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-sm btn-danger remove-item">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr class="new-item-row">
                                                            <td>
                                                                <input type="text" class="form-control new-item" placeholder="Add new infrastructure type...">
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-success add-item">
                                                                    <i class="bi bi-plus-circle"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Damage Status Category -->
                        <div class="tab-pane fade" id="damage-status" role="tabpanel" aria-labelledby="damage-status-tab">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Damage Status</h5>
                                </div>
                                <div class="card-body">
                                    <div class="category-container" data-category-key="damage_status">
                                        <p class="text-muted mb-3">Define the possible damage status values in the system.</p>
                                        
                                        <input type="hidden" name="categories[damage_status][description]" value="Types of Damage Status">
                                        <input type="hidden" name="categories[damage_status][type]" value="category">
                                        
                                        <div class="mb-3">
                                            <div class="table-responsive">
                                                <table class="table table-bordered category-table">
                                                    <thead>
                                                        <tr>
                                                            <th width="90%">Status</th>
                                                            <th width="10%">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach(category('damage_status', 'dtms', []) as $index => $item)
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control" 
                                                                        name="categories[damage_status][value][]" 
                                                                        value="{{ $item }}" required>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-sm btn-danger remove-item">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr class="new-item-row">
                                                            <td>
                                                                <input type="text" class="form-control new-item" placeholder="Add new damage status...">
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-success add-item">
                                                                    <i class="bi bi-plus-circle"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Damage Nature Category -->
                        <div class="tab-pane fade" id="damage-nature" role="tabpanel" aria-labelledby="damage-nature-tab">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Damage Nature</h5>
                                </div>
                                <div class="card-body">
                                    <div class="category-container" data-category-key="damage_nature">
                                        <p class="text-muted mb-3">Define the possible damage nature types in the system.</p>
                                        
                                        <input type="hidden" name="categories[damage_nature][description]" value="Types of Damage Nature">
                                        <input type="hidden" name="categories[damage_nature][type]" value="category">
                                        
                                        <div class="mb-3">
                                            <div class="table-responsive">
                                                <table class="table table-bordered category-table">
                                                    <thead>
                                                        <tr>
                                                            <th width="90%">Nature</th>
                                                            <th width="10%">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach(category('damage_nature', 'dtms', []) as $index => $item)
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control" 
                                                                        name="categories[damage_nature][value][]" 
                                                                        value="{{ $item }}" required>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-sm btn-danger remove-item">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr class="new-item-row">
                                                            <td>
                                                                <input type="text" class="form-control new-item" placeholder="Add new damage nature...">
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-success add-item">
                                                                    <i class="bi bi-plus-circle"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Save Settings Button - Fixed at Bottom -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-save me-1"></i> Save All Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
    <script>
        $(document).ready(function() {
            $('.settings-tab').on('shown.bs.tab', function (e) {
                localStorage.setItem('activeSettingsTab', e.target.id);
            });

            var activeTab = localStorage.getItem('activeSettingsTab');
            if (activeTab) {
                $('#' + activeTab).tab('show');
            }

            $(document).on('click', '.add-item', function() {
                addNewItem($(this));
            });
            
            $(document).on('keypress', '.new-item', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    addNewItem($(this).closest('tr').find('.add-item'));
                }
            });
            
            function addNewItem(button) {
                const row = button.closest('tr');
                const input = row.find('.new-item');
                const value = input.val().trim();
                const categoryContainer = button.closest('.category-container');
                const categoryKey = categoryContainer.data('category-key') || '';
                
                if (value === '') {
                    alert('Item cannot be empty!');
                    return;
                }
                
                const newRow = `
                    <tr class="item-row">
                        <td>
                            <input type="text" class="form-control" 
                                name="categories[${categoryKey}][value][]" 
                                value="${value}" required>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger remove-item">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                
                const table = row.closest('table');
                $(newRow).insertBefore(row);
                
                input.val('');
            }
            
            $(document).on('click', '.remove-item', function() {
                const table = $(this).closest('table');
                $(this).closest('tr').remove();
            });
            
            $('#settingsForm').on('submit', function(e) {
                $('.new-item').each(function() {
                    const value = $(this).val().trim();
                    if (value !== '') {
                        const categoryContainer = $(this).closest('.category-container');
                        const categoryKey = categoryContainer.data('category-key') || '';
                        
                        if (categoryKey) {
                            $('<input>').attr({
                                type: 'hidden',
                                name: `categories[${categoryKey}][value][]`,
                                value: value
                            }).appendTo('#settingsForm');
                        }
                    }
                });
                
                return true;
            });

            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            });
        });
    </script>
    @endpush
</x-dtms-layout>