<x-app-layout>
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
                                    <input type="text" class="form-control" id="owner_name" value="{{ old('owner_name') }}" placeholder="Name of Owner" name="owner_name" required>
                                    @error('owner_name')
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
                                    <label for="owner_name">Password</label>
                                    <input type="text" class="form-control" id="owner_name" value="{{ old('owner_name') }}" placeholder="Name of Owner" name="owner_name" required>
                                    @error('owner_name')
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
                                    <label for="mobile_number">Landline Number.</label>
                                    <input type="text" class="form-control" id="mobile_number" value="{{ old('mobile_number') }}" placeholder="Mobile No" name="mobile_number" required>
                                    @error('mobile_number')
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
                                    <label for="category_applied">Designation</label>
                                    <select class="form-select" id="category_applied" name="category_applied" required>
                                        <option value="">Choose...</option>
                                        @foreach ($cat['designations'] as $designation)
                                        <option value="{{ $designation->name }}">{{ $designation->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('designations')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="category_applied">Office</label>
                                    <select class="form-select" id="category_applied" name="category_applied" required>
                                        <option value="">Choose...</option>
                                        @foreach ($cat['offices'] as $office)
                                        <option value="{{ $office->name }}">{{ $office->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('offices')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">  
                                <div class="col-md-6">
                                    <label for="cnic_front_attachment">Image</label>
                                    <input type="file" class="form-control" id="cnic_front_attachment" name="cnic_front_attachment" onchange="previewImage(event, 'previewCnicFront')">
                                    @error('cnic_front_attachment')
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
                                    @foreach ($cat['designations'] as $entities)
                                    <option value="{{ $entities->name }}">{{ $entities->name }}</option>
                                    @endforeach
                                </select>
                                @error('roles')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="permissions">Permissions</label>
                                <select class="form-select form-select-md" data-placeholder="Choose" id="permissions" multiple name="permissions[]">
                                    @foreach ($cat['designations'] as $entities)
                                    <option value="{{ $entities->name }}">{{ $entities->name }}</option>
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
