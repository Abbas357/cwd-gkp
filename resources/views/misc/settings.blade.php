<x-settings-layout title="Site Settings">
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
                <form class="needs-validation" action="{{ route('admin.settings.update', ['module' => 'main']) }}" method="post" novalidate>
                    @csrf
                    @method('patch')
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- General Settings -->
                                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                    <h4 class="mb-4">General Settings</h4>
                                    <div class="mb-4">
                                        <label for="settings[site_name]">Site Name</label>
                                        <input type="text" class="form-control" id="settings[site_name]" 
                                            value="{{ old('settings.site_name', setting('site_name')) }}" 
                                            name="settings[site_name][value]" required>
                                        <input type="hidden" name="settings[site_name][type]" value="string">
                                        <input type="hidden" name="settings[site_name][description]" value="Site name">
                                        @error('settings.site_name.value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="settings[description]">Description</label>
                                        <textarea name="settings[description][value]" id="settings[description]" 
                                            class="form-control" style="height:100px" required>{{ old('settings.description.value', setting('description')) }}</textarea>
                                        <input type="hidden" name="settings[description][type]" value="string">
                                        <input type="hidden" name="settings[description][description]" value="Site description">
                                        @error('settings.description.value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="settings[meta_description]">Meta Description</label>
                                        <textarea name="settings[meta_description][value]" id="settings[meta_description]" 
                                            class="form-control" style="height:100px">{{ old('settings.meta_description.value', setting('meta_description')) }}</textarea>
                                        <input type="hidden" name="settings[meta_description][type]" value="string">
                                        <input type="hidden" name="settings[meta_description][description]" value="Meta description for SEO">
                                        @error('settings.meta_description.value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="mb-3">Enable Comments</label>
                                        @php
                                            $commentableTables = setting('commentable_tables', 'main', []);
                                        @endphp
                                        @foreach($tables as $table)
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" 
                                                    type="checkbox" 
                                                    id="commentable_table_{{ $table }}" 
                                                    name="settings[commentable_tables][value][]" 
                                                    value="{{ $table }}"
                                                    {{ in_array($table, $commentableTables) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="commentable_table_{{ $table }}">
                                                    {{ ucfirst($table) }}
                                                </label>
                                            </div>
                                        @endforeach
                                        <input type="hidden" name="settings[commentable_tables][type]" value="json">
                                        <input type="hidden" name="settings[commentable_tables][description]" value="Tables that can have comments">
                                        @error('settings.commentable_tables.value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <!-- Contact Information -->
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <h4 class="mb-4">Contact Information</h4>
                                    <div class="mb-4">
                                        <label for="settings[contact_address]">Contact Address</label>
                                        <input type="text" class="form-control" id="settings[contact_address]" 
                                            value="{{ old('settings.contact_address.value', setting('contact_address')) }}" 
                                            name="settings[contact_address][value]" required>
                                        <input type="hidden" name="settings[contact_address][type]" value="string">
                                        <input type="hidden" name="settings[contact_address][description]" value="Physical address">
                                        @error('settings.contact_address.value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="settings[contact_phone]">Contact Phone</label>
                                        <input type="text" class="form-control" id="settings[contact_phone]" 
                                            value="{{ old('settings.contact_phone.value', setting('contact_phone')) }}" 
                                            name="settings[contact_phone][value]" required>
                                        <input type="hidden" name="settings[contact_phone][type]" value="string">
                                        <input type="hidden" name="settings[contact_phone][description]" value="Contact phone number">
                                        @error('settings.contact_phone.value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="settings[email]">Email</label>
                                        <input type="email" class="form-control" id="settings[email]" 
                                            value="{{ old('settings.email.value', setting('email')) }}" 
                                            name="settings[email][value]" required>
                                        <input type="hidden" name="settings[email][type]" value="string">
                                        <input type="hidden" name="settings[email][description]" value="Contact email">
                                        @error('settings.email.value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="settings[whatsapp]">WhatsApp</label>
                                        <input type="text" class="form-control" id="settings[whatsapp]" 
                                            value="{{ old('settings.whatsapp.value', setting('whatsapp')) }}" 
                                            name="settings[whatsapp][value]">
                                        <input type="hidden" name="settings[whatsapp][type]" value="string">
                                        <input type="hidden" name="settings[whatsapp][description]" value="WhatsApp number">
                                        @error('settings.whatsapp.value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Social Media -->
                                <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                                    <h4 class="mb-4">Social Media</h4>
                                    <div class="mb-4">
                                        <label for="settings[facebook]">Facebook</label>
                                        <input type="text" class="form-control" id="settings[facebook]" 
                                            value="{{ old('settings.facebook.value', setting('facebook')) }}" 
                                            name="settings[facebook][value]">
                                        <input type="hidden" name="settings[facebook][type]" value="string">
                                        <input type="hidden" name="settings[facebook][description]" value="Facebook handle">
                                        @error('settings.facebook.value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="settings[twitter]">Twitter</label>
                                        <input type="text" class="form-control" id="settings[twitter]" 
                                            value="{{ old('settings.twitter.value', setting('twitter')) }}" 
                                            name="settings[twitter][value]">
                                        <input type="hidden" name="settings[twitter][type]" value="string">
                                        <input type="hidden" name="settings[twitter][description]" value="Twitter handle">
                                        @error('settings.twitter.value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="settings[youtube]">YouTube</label>
                                        <input type="text" class="form-control" id="settings[youtube]" 
                                            value="{{ old('settings.youtube.value', setting('youtube')) }}" 
                                            name="settings[youtube][value]">
                                        <input type="hidden" name="settings[youtube][type]" value="string">
                                        <input type="hidden" name="settings[youtube][description]" value="YouTube channel">
                                        @error('settings.youtube.value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- System Settings -->
                                <div class="tab-pane fade" id="system" role="tabpanel" aria-labelledby="system-tab">
                                    <h4 class="mb-4">System Settings</h4>
                                    <div class="mb-4">
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

                                    <div class="mb-4">
                                        <label for="cache">Cache Management</label>
                                        <select class="form-select" id="cache" name="cache">
                                            <option value="">Choose ...</option>
                                            <option value="create">Create Cache</option>
                                            <option value="clear">Clear Cache</option>
                                        </select>
                                        @error('cache')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="settings[secret_key]">Secret Key</label>
                                        <input type="text" class="form-control" id="settings[secret_key]" 
                                            value="{{ old('settings.secret_key.value', setting('secret_key')) }}" 
                                            name="settings[secret_key][value]">
                                        <small class="form-text text-muted">Used during maintenance</small>
                                        <input type="hidden" name="settings[secret_key][type]" value="string">
                                        <input type="hidden" name="settings[secret_key][description]" value="Secret key for maintenance bypass">
                                        @error('settings.secret_key.value')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <h5>Lock Modules</h5>
                                        <div class="route-maintenance-list">
                                            @php
                                                $maintenanceRoutes = setting('maintenance_routes', 'main', []);
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
</x-settings-layout>