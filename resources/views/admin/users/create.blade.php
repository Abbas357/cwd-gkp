<x-app-layout title="Add Users">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add User</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title pb-4">Fill all the fields</h3>
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <label class="label" data-toggle="tooltip" title="Change Profile Picture">
                                        <img src="{{ asset('admin/images/no-profile.png') }}" id="image-label-preview" alt="avatar" class="change-image img-fluid rounded-circle">
                                        <input type="file" id="image" name="image" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="Full Name" name="name" required>
                                            @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" value="{{ old('username') }}" placeholder="Username" name="username">
                                            @error('username')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Email Address" name="email" required>
                                            @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                                            @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="mobile_number">Mobile No.</label>
                                    <input type="text" class="form-control" id="mobile_number" value="{{ old('mobile_number') }}" placeholder="Mobile No" name="mobile_number">
                                    @error('mobile_number')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="landline_number">Landline Number.</label>
                                    <input type="text" class="form-control" id="landline_number" value="{{ old('landline_number') }}" placeholder="Mobile No" name="landline_number">
                                    @error('landline_number')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cnic">CNIC Number</label>
                                    <input type="text" class="form-control" id="cnic" value="{{ old('cnic') }}" placeholder="CNIC" name="cnic">
                                    @error('cnic')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
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
                                <div class="col-md-4 mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="Title" name="title">
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
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
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="posting_type">Posting Type</label>
                                    <select class="form-select form-select-md" id="posting_type" name="posting_type">
                                        <option value="">Select Option</option>
                                        <option value="appointment">Appointment</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                    @error('posting_type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="posting_date">Posting Date</label>
                                    <input type="date" class="form-control" id="posting_date" value="{{ old('posting_date') }}" placeholder="posting_date" name="posting_date">
                                    @error('posting_date')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="posting_order">Posting Order</label>
                                    <input type="file" class="form-control" id="posting_order" name="posting_order">
                                    @error('posting_order')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="exit_type">Exit Type</label>
                                    <select class="form-select form-select-md" id="exit_type" name="exit_type">
                                        <option value="">Select Option</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="retire">Retire</option>
                                    </select>
                                    @error('exit_type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="exit_date">Exit Date</label>
                                    <input type="date" class="form-control" id="exit_date" value="{{ old('exit_date') }}" placeholder="exit_date" name="exit_date">
                                    @error('exit_date')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="exit_order">Exit Order</label>
                                    <input type="file" class="form-control" id="exit_order" name="exit_order">
                                    @error('exit_order')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h3 class="card-title pb-2">Others</h3>
                            <label for="message">Message</label>
                            <div class="mb-3">
                                <textarea name="message" id="message" class="form-control" style="height:200px">{{ old('message') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="whatsapp">WhatsApp</label>
                                <input type="text" class="form-control" id="whatsapp" value="{{ old('whatsapp') }}" placeholder="whatsapp" name="whatsapp">
                                @error('whatsapp')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="facebook">Facebook</label>
                                <input type="text" class="form-control" id="facebook" value="{{ old('facebook') }}" placeholder="facebook" name="facebook">
                                @error('facebook')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="twitter">X (Formally Twitter)</label>
                                <input type="text" class="form-control" id="twitter" value="{{ old('twitter') }}" placeholder="twitter" name="twitter">
                                @error('twitter')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Create User</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push("script")
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            imageCropper({
                fileInput: '#image'
                , inputLabelPreview: '#image-label-preview'
            , });

            imageCropper({
                fileInput: "#posting_order"
                , inputLabelPreview: "#posting_order"
                , aspectRatio: 1 / 1.58
            });

            imageCropper({
                fileInput: "#exit_order"
                , inputLabelPreview: "#exit_order"
                , aspectRatio: 1 / 1.58
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

            $('#whatsapp').mask('0000-0000000', {
                placeholder: "____-_______"
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

        });

    </script>
    @endpush
</x-app-layout>
