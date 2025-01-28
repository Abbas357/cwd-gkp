<x-app-layout title="Site Settings">
    @push('style')
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    <style>
        .nav-tabs .nav-link {
            text-align: left;
            padding-left: 20px
        }
        .nav-tabs .nav-link.active {
            background-color: #f8f9fa;
            border-left: 5px solid #0d6efd;
        }
        .settings-tab {
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
        }
        .settings-tab:hover {
            background-color: #f8f9fa;
        }
    </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Site Settings</li>
    </x-slot>

    <div class="wrapper">
        <div class="row">
            <!-- Left Navigation -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="nav flex-column nav-tabs" id="settings-tabs" role="tablist">
                            <button class="nav-link settings-tab active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                                General Settings
                            </button>
                            <button class="nav-link settings-tab" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
                                Contact Information
                            </button>
                            <button class="nav-link settings-tab" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">
                                Social Media
                            </button>
                            <button class="nav-link settings-tab" id="system-tab" data-bs-toggle="tab" data-bs-target="#system" type="button" role="tab" aria-controls="system" aria-selected="false">
                                System Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <form class="needs-validation" action="{{ route('admin.settings.update') }}" method="post" novalidate>
                    @csrf
                    @method('patch')
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- General Settings -->
                                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                    <h4 class="mb-4">General Settings</h4>
                                    <div class="mb-4">
                                        <label for="site_name">Site Name</label>
                                        <input type="text" class="form-control" id="site_name" value="{{ old('site_name', $settings->site_name) }}" name="site_name" required>
                                        @error('site_name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control" style="height:100px" required>{{ old('description', $settings->description) }}</textarea>
                                        @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" class="form-control" style="height:100px">{{ old('meta_description', $settings->meta_description) }}</textarea>
                                        @error('meta_description')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="mb-3">Enable Comments</label>
                                        @foreach($tables as $table)
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="commentable_table_{{ $table }}" 
                                                       name="commentable_tables[]" 
                                                       value="{{ $table }}"
                                                       {{ in_array($table, json_decode($settings->commentable_tables ?? '[]', true)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="commentable_table_{{ $table }}">
                                                    {{ ucfirst($table) }}
                                                </label>
                                            </div>
                                        @endforeach
                                        @error('commentable_tables')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <!-- Contact Information -->
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <h4 class="mb-4">Contact Information</h4>
                                    <div class="mb-4">
                                        <label for="contact_address">Contact Address</label>
                                        <input type="text" class="form-control" id="contact_address" value="{{ old('contact_address', $settings->contact_address) }}" name="contact_address" required>
                                        @error('contact_address')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="contact_phone">Contact Phone</label>
                                        <input type="text" class="form-control" id="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}" name="contact_phone" required>
                                        @error('contact_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" value="{{ old('email', $settings->email) }}" name="email" required>
                                        @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="whatsapp">WhatsApp</label>
                                        <input type="text" class="form-control" id="whatsapp" value="{{ old('whatsapp', $settings->whatsapp) }}" name="whatsapp">
                                        @error('whatsapp')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Social Media -->
                                <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                                    <h4 class="mb-4">Social Media</h4>
                                    <div class="mb-4">
                                        <label for="facebook">Facebook</label>
                                        <input type="text" class="form-control" id="facebook" value="{{ old('facebook', $settings->facebook) }}" name="facebook">
                                        @error('facebook')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="twitter">Twitter</label>
                                        <input type="text" class="form-control" id="twitter" value="{{ old('twitter', $settings->twitter) }}" name="twitter">
                                        @error('twitter')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="youtube">YouTube</label>
                                        <input type="text" class="form-control" id="youtube" value="{{ old('youtube', $settings->youtube) }}" name="youtube">
                                        @error('youtube')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- System Settings -->
                                <div class="tab-pane fade" id="system" role="tabpanel" aria-labelledby="system-tab">
                                    <h4 class="mb-4">System Settings</h4>
                                    <div class="mb-4">
                                        <label for="maintenance_mode">Maintenance Mode</label>
                                        <select class="form-select" id="maintenance_mode" name="maintenance_mode">
                                            <option value="0" {{ $settings->maintenance_mode === 0 ? 'selected' : '' }}>Off</option>
                                            <option value="1" {{ $settings->maintenance_mode === 1 ? 'selected' : '' }}>On</option>
                                        </select>
                                        @error('maintenance_mode')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="cache">Cache Management</label>
                                        <select class="form-select" id="cache" name="cache">
                                            <option value="">Choose ...</option>
                                            <option value="create" {{ $settings->cache === 0 ? 'selected' : '' }}>Create Cache</option>
                                            <option value="clear" {{ $settings->cache === 1 ? 'selected' : '' }}>Clear Cache</option>
                                        </select>
                                        @error('cache')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="secret_key">Secret Key</label>
                                        <input type="text" class="form-control" id="secret_key" value="{{ old('secret_key', $settings->secret_key) }}" name="secret_key">
                                        <small class="form-text text-muted">Used during maintenance</small>
                                        @error('secret_key')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <h5>Lock Modules</h5>
                                        <div class="route-maintenance-list">
                                            @php
                                                $maintenanceRoutes = is_array($settings->maintenance_routes) 
                                                    ? $settings->maintenance_routes 
                                                    : (json_decode($settings->maintenance_routes, true) ?? []);
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
                                                           name="maintenance_routes[{{ $route }}]"
                                                           value="1"
                                                           {{ isset($maintenanceRoutes[$route]) && $maintenanceRoutes[$route] ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="route_{{ $route }}">
                                                        {{ $label }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions mt-4">
                                <button class="btn btn-primary w-100" type="submit">Save Settings</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });

            let activeTab = localStorage.getItem('activeSettingsTab');
            if (activeTab) {
                $(activeTab).tab('show');
            }

            $('.nav-link').on('shown.bs.tab', function (e) {
                localStorage.setItem('activeSettingsTab', '#' + e.target.id);
            });
        });
    </script>
    @endpush
</x-app-layout>