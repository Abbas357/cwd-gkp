<x-app-layout title="Site Settings">
    @push('style')
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Site Settings</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.settings.update') }}" method="post" novalidate>
            @csrf
            @method('patch')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-secondary">Settings</span>
                            </h4>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="site_name">Site Name</label>
                                    <input type="text" class="form-control" id="site_name" value="{{ old('site_name', $settings->site_name) }}" name="site_name" required>
                                    @error('site_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" style="height:100px" required>{{ old('description', $settings->description) }}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="contact_address">Contact Address</label>
                                    <input type="text" class="form-control" id="contact_address" value="{{ old('contact_address',  $settings->contact_address) }}" name="contact_address" required>
                                    @error('contact_address')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="maintenance_mode">Maintenance Mode</label>
                                    <select class="form-select" id="maintenance_mode" name="maintenance_mode">
                                        <option value="0" {{ $settings->maintenance_mode === 0 ? 'selected' : '' }}>Off</option>
                                        <option value="1" {{ $settings->maintenance_mode ===1 ? 'selected' : '' }}>On</option>
                                    </select>
                                    @error('maintenance_mode')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="cache">Cache Management</label>
                                    <select class="form-select" id="cache" name="cache">
                                        <option value="">Choose ...</option>
                                        <option value="create" {{ $settings->cache === 0 ? 'selected' : '' }}>Create Cache</option>
                                        <option value="clear" {{ $settings->cache ===1 ? 'selected' : '' }}>Clear Cache</option>
                                    </select>
                                    @error('cache')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" class="form-control" style="height:100px">{{ old('meta_description', $settings->meta_description) }}</textarea>
                                    @error('meta_description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="contact_phone">Contact Phone</label>
                                    <input type="text" class="form-control" id="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}" name="contact_phone" required>
                                    @error('contact_phone')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" value="{{ old('email', $settings->email) }}" name="email" required>
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="whatsapp">WhatsApp</label>
                                    <input type="text" class="form-control" id="whatsapp" value="{{ old('whatsapp', $settings->whatsapp) }}" name="whatsapp">
                                    @error('whatsapp')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" class="form-control" id="facebook" value="{{ old('facebook', $settings->facebook) }}" name="facebook">
                                    @error('facebook')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="twitter">Twitter</label>
                                    <input type="text" class="form-control" id="twitter" value="{{ old('twitter', $settings->twitter) }}" name="twitter">
                                    @error('twitter')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="youtube">YouTube</label>
                                    <input type="text" class="form-control" id="youtube" value="{{ old('youtube', $settings->youtube) }}" name="youtube">
                                    @error('youtube')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="secret_key">Secret Key (Used during maintenance)</label>
                                    <input type="text" class="form-control" id="secret_key" value="{{ old('secret_key', $settings->secret_key) }}" name="secret_key">
                                    @error('secret_key')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                
                            </div>
                        </div>
                    </div>

                    <div class="form-actions mb-4 mt-2">
                        <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Save Settings</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            imageCropper({
                fileInput: "#logo_desktop",
                inputLabelPreview: "#previewDesktop",
                aspectRatio: 4 / 3
            });

            imageCropper({
                fileInput: "#logo_mobile",
                inputLabelPreview: "#previewMobile",
                aspectRatio: 1 / 1
            });

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
        });
    </script>
    @endpush
</x-app-layout>
