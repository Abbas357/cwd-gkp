<x-main-layout>
    @push('style')
        <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    
    @include('site.contractors.partials.header')

    <div class="container">
        <form class="needs-validation" action="{{ route('contractors.hr.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card cw-shadow mb-4 rounded-0">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Personal Information
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="name">Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="eg. Name of Employee" name="name" required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="father_name">Father Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="father_name" value="{{ old('father_name') }}" placeholder="Father Name" name="father_name" required>
                            @error('father_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="email">Email <abbr title="Required">*</abbr></label>
                            <input type="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Email" name="email" required>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="mobile_number">Mobile Number <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="mobile_number" value="{{ old('mobile_number') }}" placeholder="Mobile Number" name="mobile_number" required>
                            @error('mobile_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="cnic_number">CNIC Number <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="cnic" value="{{ old('cnic_number') }}" placeholder="CNIC" name="cnic_number" required>
                            @error('cnic_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="card cw-shadow mb-4 rounded-0">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Professional Information
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="designation">Designation <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="designation" value="{{ old('designation') }}" placeholder="Designation" name="designation" required>
                            @error('designation')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="pec_number">PEC Number <abbr title="Required">*</abbr></label>
                            <input type="number" class="form-control" id="pec_number" value="{{ old('pec_number') }}" placeholder="PEC Number" name="pec_number" required>
                            @error('pec_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="start_date">Start Date <abbr title="Required">*</abbr></label>
                            <input type="date" class="form-control" id="start_date" value="{{ old('start_date') }}" placeholder="Start Date" name="start_date" required>
                            @error('start_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="end_date">End Date <abbr title="Required">*</abbr></label>
                            <input type="date" class="form-control" id="end_date" value="{{ old('end_date') }}" placeholder="End Date" name="end_date" required>
                            @error('end_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="salary">Salary <abbr title="Required">*</abbr></label>
                            <input type="number" class="form-control" id="salary" value="{{ old('salary') }}" placeholder="Salary" name="salary" required>
                            @error('salary')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card cw-shadow mb-4 rounded-0">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Attachments
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="resume">Résumé (CV)</label>
                            <input type="file" class="form-control" id="resume" name="resume">
                            @error('resume')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="previewResume" src="#" alt="Resume Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-2">
                <x-button type="submit" text="Add" />
            </div>
        </form>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            imageCropper({
                fileInput: "#resume"
                , inputLabelPreview: "#previewResume"
                , aspectRatio: 4 / 6
                , onComplete() {
                    $("#previewResume").show();
                }
            });

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
