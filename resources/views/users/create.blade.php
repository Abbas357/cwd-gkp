<x-app-layout title="Add Users">
    @push('style')
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add User</li>
    </x-slot>

    <div class="wrapper">
        <div class="row mb-3 d-none">
            <div class="col-md-4 mx-auto">
                <label for="load-users">All Users</label>
                <select class="form-select form-select-md" data-placeholder="Choose" id="load-users" name="user">
                </select>
            </div>
        </div>
        <form class="needs-validation" action="{{ route('users.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title pb-4">Fill all the fields</h3>

                            <div class="row mb-3">
                                <div class="col">
                                    <label class="label" data-toggle="tooltip" title="Change Profile Picture">
                                        <img src="{{ asset('images/no-profile.png') }}" id="image-preview" alt="avatar" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                                        <input type="file" id="image" name="image" class="sr-only" id="input" name="image" accept="image/*">
                                    </label>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="Full Name" name="name" required>
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Email Address" name="email" required>
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name">Password</label>
                                    <input type="password" class="form-control" id="password" value="{{ old('password') }}" placeholder="Password" name="password" required>
                                    @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="mobile_number">Mobile No.</label>
                                    <input type="text" class="form-control" id="mobile_number" value="{{ old('mobile_number') }}" placeholder="Mobile No" name="mobile_number" required>
                                    @error('mobile_number')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <label for="landline_number">Landline Number.</label>
                                    <input type="text" class="form-control" id="landline_number" value="{{ old('landline_number') }}" placeholder="Mobile No" name="landline_number" required>
                                    @error('landline_number')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="cnic">CNIC Number</label>
                                    <input type="text" class="form-control" id="cnic" value="{{ old('cnic') }}" placeholder="CNIC" name="cnic" required>
                                    @error('cnic')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="designation">Designation</label>
                                    <select class="form-select" id="designation" name="designation" required>
                                        <option value="">Choose...</option>
                                        @foreach ($cat['designations'] as $designation)
                                        <option value="{{ $designation->name }}">{{ $designation->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('designation')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="office">Office</label>
                                    <select class="form-select" id="office" name="office" required>
                                        <option value="">Choose...</option>
                                        @foreach ($cat['offices'] as $office)
                                        <option value="{{ $office->name }}">{{ $office->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('office')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title pb-4">Roles and Permission</h3>
                            <div class="mb-4">
                                <label for="roles">Roles</label>
                                <select class="form-select form-select-md" id="roles" multiple name="roles[]" required>
                                    @foreach ($cat['roles'] as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="permissions">Permissions <span class="text-warning">(Avoid Direct Permissions)</span></label>
                                <select class="form-select form-select-md" id="permissions" multiple name="permissions[]">
                                    @foreach ($cat['permissions'] as $permission)
                                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                                @error('permissions')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Create User</button>
                </div>
            </div>
        </form>

        <div class="modal modal-lg fade" id="crop-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Crop the image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <img id="image-cropper" style="max-height: 400px">
                        </div>
                        <div class="row" id="actions">
                            <div class="col-md-9 docs-buttons">
                                <h3>Toolbar:</h3>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;move&quot;)">
                                            <span class="bi-arrows-move"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;crop&quot;)">
                                            <span class="bi-crop"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
                                            <i class="bi bi-zoom-in"></i>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
                                            <i class="bi bi-zoom-out"></i>
                                        </span>
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(-10, 0)">
                                            <span class="bi-arrow-left"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(10, 0)">
                                            <span class="bi-arrow-right"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, -10)">
                                            <span class="bi-arrow-up"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, 10)">
                                            <span class="bi-arrow-down"></span>
                                        </span>
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleX(-1)">
                                            <i class="bi-vr"></i>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleY(-1)">
                                            <i class="bi-hr"></i>
                                        </span>
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.crop()">
                                            <span class="bi-check"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.clear()">
                                            <i class="bi-x-lg"></i>
                                        </span>
                                    </button>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.disable()">
                                            <span class="bi-lock"></span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.enable()">
                                            <span class="bi-unlock"></span>
                                        </span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="crop">Crop</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push("script")
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            var fileInput = $('#image');
            var imagePreview = $('#image-preview');
            var imageCropper = $('#image-cropper');
            var cropModal = $('#crop-modal');
            var cropper;

            fileInput.on('change', function(e) {
                var files = e.target.files;
                var done = function(url) {
                    fileInput.val('');
                    imageCropper.attr('src', url);
                    cropModal.modal('show');
                };
                var reader;
                var file;

                if (files && files.length > 0) {
                    file = files[0];

                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function(e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            cropModal.on('shown.bs.modal', function() {
                cropper = new Cropper(imageCropper[0], {
                    // aspectRatio: 16/9
                    // aspectRatio: 9/16
                    // aspectRatio: 21/9
                    // aspectRatio: 3/2
                    // aspectRatio: 4/3
                    aspectRatio: 1 / 1
                    , viewMode: 3
                });
            }).on('hidden.bs.modal', function() {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            });

            $('#crop').on('click', function() {
                var canvas;

                cropModal.modal('hide');

                if (cropper) {
                    canvas = cropper.getCroppedCanvas();

                    imagePreview.attr('src', canvas.toDataURL('image/jpeg', .7));

                    canvas.toBlob(function(blob) {
                        var file = new File([blob], 'cropped_image.jpg', {
                            type: 'image/jpeg'
                        });

                        var dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        fileInput[0].files = dataTransfer.files;

                    }, 'image/jpeg', .7);
                }
            });

            // Methods
            actions.querySelector('.docs-buttons').onclick = function(event) {
                var e = event || window.event;
                var target = e.target || e.srcElement;
                var cropped;
                var result;
                var input;
                var data;

                if (!cropper) {
                    return;
                }

                while (target !== this) {
                    if (target.getAttribute('data-method')) {
                        break;
                    }

                    target = target.parentNode;
                }

                if (target === this || target.disabled || target.className.indexOf('disabled') > -1) {
                    return;
                }

                data = {
                    method: target.getAttribute('data-method')
                    , target: target.getAttribute('data-target')
                    , option: target.getAttribute('data-option') || undefined
                    , secondOption: target.getAttribute('data-second-option') || undefined
                };

                cropped = cropper.cropped;

                if (data.method) {
                    if (typeof data.target !== 'undefined') {
                        input = document.querySelector(data.target);

                        if (!target.hasAttribute('data-option') && data.target && input) {
                            try {
                                data.option = JSON.parse(input.value);
                            } catch (e) {
                                console.log(e.message);
                            }
                        }
                    }

                    switch (data.method) {
                        case 'rotate':
                            if (cropped && options.viewMode > 0) {
                                cropper.clear();
                            }

                            break;

                        case 'getCroppedCanvas':
                            try {
                                data.option = JSON.parse(data.option);
                            } catch (e) {
                                console.log(e.message);
                            }

                            if (uploadedImageType === 'image/jpeg') {
                                if (!data.option) {
                                    data.option = {};
                                }

                                data.option.fillColor = '#fff';
                            }

                            break;
                    }

                    result = cropper[data.method](data.option, data.secondOption);

                    switch (data.method) {
                        case 'rotate':
                            if (cropped && options.viewMode > 0) {
                                cropper.crop();
                            }

                            break;

                        case 'scaleX':
                        case 'scaleY':
                            target.setAttribute('data-option', -data.option);
                            break;

                        case 'destroy':
                            cropper = null;

                            if (uploadedImageURL) {
                                URL.revokeObjectURL(uploadedImageURL);
                                uploadedImageURL = '';
                                image.src = originalImageURL;
                            }

                            break;
                    }
                }
            };

            $('#mobile_number').mask('0000-0000000', {
                placeholder: "____-_______"
            });

            $('#landline_number').mask('000-000000', {
                placeholder: "___-______"
            });

            $('#cnic').mask('00000-0000000-0', {
                placeholder: "_____-_______-_"
            });

            $('#office').select2({
                theme: "bootstrap-5"
                , placeholder: "Choose office"
                , dropdownParent: $('#office').parent()
                , allowClear: true
            });

            $('#designation').select2({
                theme: "bootstrap-5"
                , placeholder: "Choose designation"
                , dropdownParent: $('#designation').parent()
                , allowClear: true
            , });

            $('#roles').select2({
                theme: "bootstrap-5"
                , placeholder: "Choose Roles"
                , dropdownParent: $('#roles').parent()
                , allowClear: true
                , closeOnSelect: false
            });

            $('#permissions').select2({
                theme: "bootstrap-5"
                , placeholder: "Choose Permissions"
                , dropdownParent: $('#permissions').parent()
                , allowClear: true
                , closeOnSelect: false
            });

            $('#load-users').select2({
                theme: "bootstrap-5"
                , dropdownParent: $('#load-users').parent()
                , ajax: {
                    url: '{{ route("users.api") }}'
                    , dataType: 'json'
                    , data: function(params) {
                        return {
                            q: params.term
                            , page: params.page || 1
                        };
                    }
                    , processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items
                            , pagination: {
                                more: data.pagination.more
                            }
                        };
                    }
                    , cache: true
                }
                , minimumInputLength: 0
                , templateResult(user) {
                    return user.name;
                }
                , templateSelection(user) {
                    return user.name;
                }
            });

        });

    </script>
    @endpush
</x-app-layout>
