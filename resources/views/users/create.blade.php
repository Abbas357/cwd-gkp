<x-app-layout title="List of Users">
    @push('style')
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add User</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('users.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow rounded border-2">
                        <div class="card-body">
                            <h3 class="card-title pb-4">Fill all the fields</h3>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="owner_name">Name</label>
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

                            <div class="row mb-3">  
                                <div class="col-md-6">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" id="image" name="image" onchange="previewImage(event, 'previewCnicFront')">
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <img id="previewCnicFront" src="#" alt="CNIC Front Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow rounded border-2">
                        <div class="card-body">
                            <h3 class="card-title pb-4">Roles and Permission</h3>
                            <div class="mb-3">
                                <label for="roles">Roles</label>
                                <select class="form-select form-select-md" data-placeholder="Choose" id="roles" multiple name="roles[]">
                                    @foreach ($cat['roles'] as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="permissions">Permissions</label>
                                <select class="form-select form-select-md" data-placeholder="Choose" id="permissions" multiple name="permissions[]">
                                    @foreach ($cat['permissions'] as $permission)
                                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                                @error('permissions')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-actions">
                                <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Create User</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push("script")
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#mobile_number').mask('0000-0000000', {
                placeholder: "____-_______"
            });

            $('#landline_number').mask('000-000000', {
                placeholder: "___-______"
            });

            $('#cnic').mask('00000-0000000-0', {
                placeholder: "_____-_______-_"
            });

            $('#roles').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                closeOnSelect: false,
                dropdownParent: $( '#roles' ).parent(),
            });

            $('#permissions').select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                closeOnSelect: false,
                dropdownParent: $( '#permissions' ).parent(),
            });



        });

    </script>
    @endpush
</x-app-layout>
