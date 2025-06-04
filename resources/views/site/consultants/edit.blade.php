<x-main-layout>
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    <style>
        .warning-label {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .border-danger {
            border-color: #dc3545 !important;
        }

        .border-danger:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
        }

    </style>
    @endpush
    @include('site.consultants.partials.header')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Edit your information</h2>
        </div>
        <form action="{{ route('consultants.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="card mb-4">
                <div class="card-header bg-light fw-bold text-uppercase text-center">
                    Personal Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name">Firm Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="name" value="{{ old('name', $consultant->name) }}" name="name" required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email">Email Address <abbr title="Required">*</abbr></label>
                            <input type="email" class="form-control" id="email" value="{{ old('email', $consultant->email) }}" placeholder="eg. aslam@gmail.com" name="email" required>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="contact_number">Contact Number. <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="contact_number" value="{{ old('contact_number', $consultant->contact_number) }}" placeholder="eg. 0333-3333333" name="contact_number" required>
                            @error('contact_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="district_id">District <abbr title="Required">*</abbr></label>
                            <select class="form-select" id="district_id" name="district_id" required>
                                <option value="">Choose...</option>
                                @foreach ($cat['districts'] as $district)
                                <option value="{{ $district->id }}" {{ $consultant->district_id == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('district_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="sector">Sector <abbr title="Required">*</abbr></label>
                            <select class="form-select" id="sector" name="sector" required>
                                <option value="">Choose...</option>
                                @foreach ($cat['sectors'] as $sector)
                                <option value="{{ $sector }}" {{ $consultant->sector == $sector ? 'selected' : '' }}>{{ $sector }}</option>
                                @endforeach
                            </select>
                            @error('sector')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="address">Address (as per PEC) <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="address" value="{{ old('address', $consultant->address) }}" placeholder="eg. Dir Upper" name="address" required>
                            @error('address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('consultants.dashboard') }}" class="btn btn-light me-2">Cancel</a>
                <x-button type="submit" text="Update Consultant" />
            </div>
        </form>
    </div>
    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            imageCropper({
                fileInput: "#consultant_picture"
                , inputLabelPreview: "#previewConsultantPicture"
                , aspectRatio: 5 / 6
                , onComplete() {
                    $("#previewConsultantPicture").show();
                }
            });

            imageCropper({
                fileInput: "#cnic_front"
                , inputLabelPreview: "#previewCnicFront"
                , aspectRatio: 1.58 / 1
                , onComplete() {
                    $("#previewCnicFront").show();
                }
            });

            imageCropper({
                fileInput: "#cnic_back"
                , inputLabelPreview: "#previewCnicBack"
                , aspectRatio: 1.58 / 1
                , onComplete() {
                    $("#previewCnicBack").show();
                }
            });

            $('#district').select2({
                theme: "bootstrap-5"
                , placeholder: $(this).data('placeholder')
                , dropdownParent: $('#district').parent()
            , });

            $('#mobile_number').mask('0000-0000000', {
                placeholder: "____-_______"
            });

            $('#cnic').mask('00000-0000000-0', {
                placeholder: "_____-_______-_"
            });

        });

    </script>
    @endpush
</x-main-layout>
