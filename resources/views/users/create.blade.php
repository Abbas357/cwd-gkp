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
                                        <img src="{{ asset('images/no-profile.png') }}" id="profile-picture" alt="avatar" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
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
                            <img id="image-canvas" style="max-height: 400px">
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

            var imageInput = $('#image');
            var imageAvatar = $('#profile-picture');
            var imageCanvas = $('#image-canvas');
            var cropModal = $('#crop-modal');
            var cropper;

            imageInput.on('change', function(e) {
                var files = e.target.files;
                var done = function(url) {
                    imageInput.val('');
                    imageCanvas.attr('src', url);
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
                cropper = new Cropper(imageCanvas[0], {
                    // aspectRatio: 16/9
                    // aspectRatio: 9/16
                    // aspectRatio: 21/9
                    // aspectRatio: 3/2
                    // aspectRatio: 4/3
                    aspectRatio: 1/1
                    , viewMode: 3
                , });
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

                    imageAvatar.attr('src', canvas.toDataURL('image/jpeg', .7));

                    canvas.toBlob(function(blob) {
                        var file = new File([blob], 'cropped_image.jpg', {
                            type: 'image/jpeg'
                        });

                        var dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        imageInput[0].files = dataTransfer.files;

                    }, 'image/jpeg', .7);
                }
            });


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
