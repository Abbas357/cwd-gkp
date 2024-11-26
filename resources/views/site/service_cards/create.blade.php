<x-main-layout title="Online apply for Service Card">
    @push('style')
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush

    <x-slot name="breadcrumbTitle">
        Online apply for Service Card
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Service Card</li>
    </x-slot>

    <div class="wrapper mt-2">
        <div class="page container">
            <div class="page-inner">
                <div class="page-section shadow-lg rounded bg-light" style="border:1px solid #dedede">
                    <form class="needs-validation" action="{{ route('service_cards.store') }}" method="post" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card m-2 shadow border border-light rounded border-2">
                                    <div class="card-body">
                                        <h3 class="card-title">Fill all the fields</h3>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="name">Full Name <span class="help" title="Required">*</span></label>
                                                <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="Full Name" name="name" required>
                                                @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="father_name">Father Name <span class="help" title="Required">*</span></label>
                                                <input type="text" class="form-control" id="father_name" value="{{ old('father_name') }}" placeholder="Father Name" name="father_name" required>
                                                @error('father_name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="date_of_birth">Date of Birth <span class="help" title="Required">*</span></label>
                                                <input type="date" class="form-control" id="date_of_birth" value="{{ old('date_of_birth') }}" placeholder="Date of Birth" name="date_of_birth" required>
                                                @error('date_of_birth')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mark_of_identification">Mark of Identification</label>
                                                <input type="text" class="form-control" id="mark_of_identification" value="{{ old('mark_of_identification') }}" placeholder="Mark of Identification" name="mark_of_identification">
                                                @error('mark_of_identification')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="cnic">CNIC Number <span class="help" title="Required">*</span></label>
                                                <input type="text" class="form-control" id="cnic" value="{{ old('cnic') }}" placeholder="CNIC Number" name="cnic" required>
                                                @error('cnic')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email">Email <span class="help" title="Required">*</span></label>
                                                <input type="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Email" name="email" required>
                                                @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="landline_number">Landline Number</label>
                                                <input type="text" class="form-control" id="landline_number" value="{{ old('landline_number') }}" placeholder="Phone Number" name="landline_number">
                                                @error('landline_number')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mobile_number">Mobile Number <span class="help" title="Required">*</span></label>
                                                <input type="text" class="form-control" id="mobile_number" value="{{ old('mobile_number') }}" placeholder="Mobile Number" name="mobile_number" required>
                                                @error('mobile_number')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="personnel_number">Personnel Number <span class="help" title="Required">*</span></label>
                                                <input type="text" class="form-control" id="personnel_number" value="{{ old('personnel_number') }}" placeholder="Personnel Number" name="personnel_number" required>
                                                @error('personnel_number')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="blood_group">Blood Group</label>
                                                <select class="form-select" id="blood_group" name="blood_group" required>
                                                    <option value="">Choose...</option>
                                                    @foreach ($cat['blood_groups'] as $blood_group)
                                                    <option value="{{ $blood_group }}">{{ $blood_group }}</option>
                                                    @endforeach
                                                </select>
                                                @error('blood_group')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="emergency_contact">Emergency Contact</label>
                                                <input type="text" class="form-control" id="emergency_contact" value="{{ old('emergency_contact') }}" placeholder="Emergency Contact" name="emergency_contact">
                                                @error('emergency_contact')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="parmanent_address">Parmanent Address <span class="help" title="Required">*</span></label>
                                                <input type="text" class="form-control" id="parmanent_address" value="{{ old('parmanent_address') }}" placeholder="Parmanent Address" name="parmanent_address" required>
                                                @error('parmanent_address')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="present_address">Present Address <span class="help" title="Required">*</span></label>
                                                <input type="text" class="form-control" id="present_address" value="{{ old('present_address') }}" placeholder="Present Address" name="present_address" required>
                                                @error('present_address')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="designation">Designation <span class="help" title="Required">*</span></label>
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
                                                <label for="bps">BPS</label>
                                                <select class="form-select" id="bps" name="bps" required>
                                                    <option value="">Choose...</option>
                                                    @foreach ($cat['bps'] as $bps)
                                                    <option value="{{ $bps }}">{{ $bps }}</option>
                                                    @endforeach
                                                </select>
                                                @error('bps')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="office">Office <span class="help" title="Required">*</span></label>
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
                                <div class="card m-2 shadow border border-light rounded border-2">
                                    <div class="card-body">
                                        <h3 class="card-title mb-3">Uploads</h3>

                                        <div class="mb-3">
                                            <label for="profile_picture">Display Picture (Picture on Card) <span class="help" title="Required">*</span></label>
                                            <input type="file" class="form-control mt-2" id="profile_picture" name="profile_picture" required>
                                            @error('profile_picture')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="profile_picture_preview" src="#" alt="Card Picture" style="display:none; margin-top: 10px; max-height: 200px;">
                                        </div>

                                        <div class="alert alert-warning" role="alert">
                                            <strong>Important Notice: </strong> Any incorrect information in your application will result in an rejection of your request for a card. Ensure all details are accurate, as rejected applications will require an in-person office visit to resolve. Please double-check every entry carefully—mistakes will lead to delays!
                                        </div>

                                        <div class="form-actions">
                                            <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Apply</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push("script")
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            imageCropper({
                fileInput: "#profile_picture"
                , inputLabelPreview: "#profile_picture_preview"
                , aspectRatio: 5 / 6
                , onComplete() {
                    $("#profile_picture_preview").show();
                }
            });

            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            });

            $('#mobile_number').mask('0000-0000000', {
                placeholder: "____-_______"
            });

            $('#emergency_contact').mask('0000-0000000', {
                placeholder: "____-_______"
            });

            $('#cnic').mask('00000-0000000-0', {
                placeholder: "_____-_______-_"
            });

        });

    </script>
    @endpush
</x-main-layout>
