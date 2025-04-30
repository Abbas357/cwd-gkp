<x-settings-layout title="Main Settings" :showAside="false">
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
                            <button class="nav-link settings-tab" id="contact-information-tab" data-bs-toggle="tab" data-bs-target="#contact-information" type="button" role="tab" aria-controls="contact-information" aria-selected="false">
                                <i class="bi bi-signpost me-2"></i> Contact Information
                            </button>
                            <button class="nav-link settings-tab" id="system-settings-tab" data-bs-toggle="tab" data-bs-target="#system-settings" type="button" role="tab" aria-controls="system-settings" aria-selected="false">
                                <i class="bi bi-building me-2"></i> System Settings
                            </button>
                            <button class="nav-link settings-tab" id="page_type-tab" data-bs-toggle="tab" data-bs-target="#page_type" type="button" role="tab" aria-controls="page_type" aria-selected="false">
                                <i class="bi bi-exclamation-triangle me-2"></i> Page Type
                            </button>
                            <button class="nav-link settings-tab" id="download_category-tab" data-bs-toggle="tab" data-bs-target="#download_category" type="button" role="tab" aria-controls="download_category" aria-selected="false">
                                <i class="bi bi-exclamation-triangle me-2"></i> Download Category
                            </button>
                            <button class="nav-link settings-tab" id="gallery_type-tab" data-bs-toggle="tab" data-bs-target="#gallery_type" type="button" role="tab" aria-controls="gallery_type" aria-selected="false">
                                <i class="bi bi-exclamation-triangle me-2"></i> Gallery Type
                            </button>
                            <button class="nav-link settings-tab" id="news_category-tab" data-bs-toggle="tab" data-bs-target="#news_category" type="button" role="tab" aria-controls="news_category" aria-selected="false">
                                <i class="bi bi-exclamation-triangle me-2"></i> News Category
                            </button>
                            @can('manageDistricts', App\Models\Setting::class)
                            <a class="nav-link settings-tab" href="{{ route('admin.districts.index') }}">
                                <i class="bi-map me-2"></i> Districts
                            </a>
                            @endcan
                            @can('viewActivity', App\Models\Setting::class)
                            <a class="nav-link settings-tab" href="{{ route('admin.activity.index') }}">
                                <i class="bi-clipboard-pulse me-2"></i> Activity Log
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <form action="{{ route('admin.settings.init') }}" method="POST" onsubmit="return confirm('This will reset all settings to default values. Continue?');">
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
                <form id="settingsForm" action="{{ route('admin.settings.update') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="tab-content">
                        <!-- General Settings -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">General Settings</h5>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label for="site_name" class="form-label">Site Name</label>
                                        <input type="text" id="site_name" name="settings[site_name][value]" value="{{ old('settings[site_name][value]', setting('site_name', 'main')) }}" class="form-control @error('site_name') is-invalid @enderror"" placeholder="Site Name" required>
                                        @error('settings.site_name.value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <input type="text" id="description" name="settings[description][value]" value="{{ old('settings[description][value]', setting('description', 'main')) }}" class="form-control @error('description') is-invalid @enderror"" placeholder="Description" required>
                                        @error('settings.description.value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <input type="text" id="meta_description" name="settings[meta_description][value]" value="{{ old('settings[meta_description][value]', setting('meta_description', 'main')) }}" class="form-control @error('meta_description') is-invalid @enderror"" placeholder="Meta Description" required>
                                        @error('settings.meta_description.value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Type Category -->
                        <div class="tab-pane fade" id="contact-information" role="tabpanel" aria-labelledby="contact-information-tab">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Contact Information</h5>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label for="contact_address" class="form-label">Contact Address</label>
                                        <input type="text" id="contact_address" name="settings[contact_address][value]" value="{{ old('settings[contact_address][value]', setting('contact_address', 'main')) }}" class="form-control @error('contact_address') is-invalid @enderror"" placeholder="Contact Address" required>
                                        @error('settings.contact_address.value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="contact_phone" class="form-label">Contact Phone</label>
                                        <input type="text" id="contact_phone" name="settings[contact_phone][value]" value="{{ old('settings[contact_phone][value]', setting('contact_phone', 'main')) }}" class="form-control @error('contact_phone') is-invalid @enderror"" placeholder="Contact Phone" required>
                                        @error('settings.contact_phone.value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" id="email" name="settings[email][value]" value="{{ old('settings[email][value]', setting('email', 'main')) }}" class="form-control @error('email') is-invalid @enderror"" placeholder="Email" required>
                                        @error('settings.email.value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="whatsapp" class="form-label">Whatsapp</label>
                                        <input type="text" id="whatsapp" name="settings[whatsapp][value]" value="{{ old('settings[whatsapp][value]', setting('whatsapp', 'main')) }}" class="form-control @error('whatsapp') is-invalid @enderror"" placeholder="Whatsapp" required>
                                        @error('settings.whatsapp.value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="facebook" class="form-label">Facebook</label>
                                        <input type="text" id="facebook" name="settings[facebook][value]" value="{{ old('settings[facebook][value]', setting('facebook', 'main')) }}" class="form-control @error('facebook') is-invalid @enderror"" placeholder="Facebook" required>
                                        @error('settings.facebook.value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="twitter" class="form-label">Twitter</label>
                                        <input type="text" id="twitter" name="settings[twitter][value]" value="{{ old('settings[twitter][value]', setting('twitter', 'main')) }}" class="form-control @error('twitter') is-invalid @enderror"" placeholder="Twitter" required>
                                        @error('settings.twitter.value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="youtube" class="form-label">Youtube</label>
                                        <input type="text" id="youtube" name="settings[youtube][value]" value="{{ old('settings[youtube][value]', setting('youtube', 'main')) }}" class="form-control @error('youtube') is-invalid @enderror"" placeholder="Youtube" required>
                                        @error('settings.youtube.value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="system-settings" role="tabpanel" aria-labelledby="system-settings-tab">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">System Settings</h5>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label for="secret_key" class="form-label">Secret Key</label>
                                        <input type="text" id="secret_key" name="settings[secret_key][value]" value="{{ old('settings[secret_key][value]', setting('secret_key', 'main')) }}" class="form-control @error('secret_key') is-invalid @enderror"" placeholder="Secret Key" required>
                                        @error('settings.secret_key.value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <h5>Lock Modules</h5>
                                        <div class="route-maintenance-list">
                                            @php
                                                $maintenanceRoutes = setting('maintenance_routes', 'main', []);
                                                if (is_string($maintenanceRoutes)) {
                                                    $maintenanceRoutes = json_decode($maintenanceRoutes, true) ?? [];
                                                }
                                            @endphp
                                            
                                            @foreach([
                                                'service_cards.*' => 'Service Card',
                                                'contractors.*' => 'Contractor',
                                                'standardizations.*' => 'Standardization'
                                            ] as $route => $label)
                                                <div class="form-check mb-2">
                                                    <input type="checkbox" 
                                                           class="form-check-input route-group" 
                                                           id="route_{{ $route }}"
                                                           name="settings[maintenance_routes][value][{{ $route }}]"
                                                           value="1"
                                                           {{ isset($maintenanceRoutes[$route]) && $maintenanceRoutes[$route] ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="route_{{ $route }}">
                                                        {{ $label }}
                                                    </label>
                                                </div>
                                            @endforeach
                                            <input type="hidden" name="settings[maintenance_routes][type]" value="json">
                                            <input type="hidden" name="settings[maintenance_routes][description]" value="Routes exempt from maintenance mode">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="settings[maintenance_mode]">Maintenance Mode</label>
                                        <select class="form-select" id="settings[maintenance_mode]" name="settings[maintenance_mode][value]">
                                            <option value="0" {{ setting('maintenance_mode') == false ? 'selected' : '' }}>Off</option>
                                            <option value="1" {{ setting('maintenance_mode') == true ? 'selected' : '' }}>On</option>
                                        </select>
                                        <input type="hidden" name="settings[maintenance_mode][type]" value="boolean">
                                        <input type="hidden" name="settings[maintenance_mode][description]" value="Website maintenance mode">
                                        @error('settings.maintenance_mode.value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="cache">Cache Management</label>
                                        <select class="form-select" id="cache" name="cache">
                                            <option value="">Choose ...</option>
                                            <option value="create">Create Cache</option>
                                            <option value="clear">Clear Cache</option>
                                        </select>
                                        <small class="text-muted">Select an option to manage application cache</small>
                                        @error('cache')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="page_type" role="tabpanel" aria-labelledby="page_type-tab">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Page Type</h5>
                                </div>
                                <div class="card-body">
                                    <div class="category-container" data-category-key="page_type">
                                        <p class="text-muted mb-3">Define the different types of pages in the system.</p>
                                        
                                        <input type="hidden" name="categories[page_type][description]" value="Page Type">
                                        <input type="hidden" name="categories[page_type][type]" value="category">
                                        
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
                                                        @foreach(category('page_type', 'main', []) as $index => $item)
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control" 
                                                                        name="categories[page_type][value][]" 
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
                                                                <input type="text" class="form-control new-item" placeholder="Add new page type...">
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

                        <div class="tab-pane fade" id="download_category" role="tabpanel" aria-labelledby="download_category-tab">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Page Type</h5>
                                </div>
                                <div class="card-body">
                                    <div class="category-container" data-category-key="download_category">
                                        <p class="text-muted mb-3">Define the different types of pages in the system.</p>
                                        
                                        <input type="hidden" name="categories[download_category][description]" value="Page Type">
                                        <input type="hidden" name="categories[download_category][type]" value="category">
                                        
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
                                                        @foreach(category('download_category', 'main', []) as $index => $item)
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control" 
                                                                        name="categories[download_category][value][]" 
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
                                                                <input type="text" class="form-control new-item" placeholder="Add new download category...">
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

                        <div class="tab-pane fade" id="gallery_type" role="tabpanel" aria-labelledby="gallery_type-tab">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Page Type</h5>
                                </div>
                                <div class="card-body">
                                    <div class="category-container" data-category-key="gallery_type">
                                        <p class="text-muted mb-3">Define the different types of pages in the system.</p>
                                        
                                        <input type="hidden" name="categories[gallery_type][description]" value="Page Type">
                                        <input type="hidden" name="categories[gallery_type][type]" value="category">
                                        
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
                                                        @foreach(category('gallery_type', 'main', []) as $index => $item)
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control" 
                                                                        name="categories[gallery_type][value][]" 
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
                                                                <input type="text" class="form-control new-item" placeholder="Add new gallery type...">
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

                        <div class="tab-pane fade" id="news_category" role="tabpanel" aria-labelledby="news_category-tab">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Page Type</h5>
                                </div>
                                <div class="card-body">
                                    <div class="category-container" data-category-key="news_category">
                                        <p class="text-muted mb-3">Define the different types of pages in the system.</p>
                                        
                                        <input type="hidden" name="categories[news_category][description]" value="Page Type">
                                        <input type="hidden" name="categories[news_category][type]" value="category">
                                        
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
                                                        @foreach(category('news_category', 'main', []) as $index => $item)
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control" 
                                                                        name="categories[news_category][value][]" 
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
                                                                <input type="text" class="form-control new-item" placeholder="Add new news category...">
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
</x-settings-layout>