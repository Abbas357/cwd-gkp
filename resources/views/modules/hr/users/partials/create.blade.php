<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">

<div class="row" id="step-1">
    <div class="col-md-6 mb-3">
        <label for="name">Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="email">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
        @error('email')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="password">Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        @error('password')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="landline_number">Landline Number</label>
        <input type="text" class="form-control" id="landline_number" placeholder="Phone/Landline Number" name="profile[landline_number]">
        @error('landline_number')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row" id="step-2">

    <div class="col-md-6 mb-3">
        <label for="office_id">Office <span class="text-danger">*</span></label>
        <select class="form-select" id="office_id" name="posting[office_id]" required>
            <option value="">Select Office</option>
            @foreach($data['offices'] as $office)
                <option value="{{ $office->id }}">{{ $office->name }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="designation_id">Designation <span class="text-danger">*</span></label>
        <select class="form-select" id="designation_id" name="posting[designation_id]" required>
            <option value="">Select Designation</option>
            @foreach($data['designations'] as $designation)
                <option value="{{ $designation->id }}">{{ $designation->name }}</option>
            @endforeach
        </select>
        <div id="vacancy-info" class="mt-2 small"></div>
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="posting_type">Posting Type <span class="text-danger">*</span></label>
        <select class="form-select" id="posting_type" name="posting[type]" required>
            <option value="">Select Posting Type</option>
            @foreach($data['postingTypes'] as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="start_date">Start Date</label>
        <input type="date" class="form-control" id="start_date" name="posting[start_date]" value="{{ date('Y-m-d') }}">
    </div>
</div>

<div class="row" id="step-3">
    Will be added later
</div>
<div class="row" id="step-4">
    <div class="col-md-12 d-flex justify-content-center align-items-center">
        <label class="label" data-toggle="tooltip" title="Change Profile Picture">
            <img src="{{ asset('admin/images/no-profile.png') }}" id="image-label-preview" alt="avatar" class="change-image img-fluid rounded-circle">
            <input type="file" id="image" name="image" class="sr-only" accept="image/*">
        </label>
    </div>
    <div class="col-md-12 mb-3">
        <label for="posting_order">Posting Order</label>
        <input type="file" class="form-control" id="posting_order" name="posting_order">
        @error('posting_order')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>

<script>
$(document).ready(function() {

    $('#office_id, #designation_id, #posting_type').select2({
        theme: "bootstrap-5",
        width: '100%',
        placeholder: 'Select option',
        dropdownParent: $('#office_id').closest('.modal')
    });

    imageCropper({
        fileInput: '#image'
        , inputLabelPreview: '#image-label-preview'
        , aspectRatio: 9 / 10
    , });
    
    // Function to check sanctioned post vacancies
    function checkVacancies() {
        const officeId = $('#office_id').val();
        const designationId = $('#designation_id').val();
        
        if (officeId && designationId) {
            $('#vacancy-info').html('<span class="text-info">Checking vacancy...</span>');
            
            $.ajax({
                url: "{{ route('admin.apps.hr.sanctioned-posts.available-positions') }}",
                type: "GET",
                data: {
                    office_id: officeId
                },
                success: function(data) {
                    const position = data.find(p => p.id == designationId);
                    
                    if (position) {
                        if (position.is_full) {
                            $('#vacancy-info').html(`<span class="text-danger">No vacancy available. (${position.filled}/${position.total} positions filled)</span>`);
                        } else {
                            $('#vacancy-info').html(`<span class="text-success">Vacancy available. (${position.filled}/${position.total} positions filled)</span>`);
                        }
                    } else {
                        $('#vacancy-info').html('<span class="text-danger">This position is not sanctioned for the selected office.</span>');
                    }
                },
                error: function() {
                    $('#vacancy-info').html('<span class="text-danger">Error checking vacancy.</span>');
                }
            });
        } else {
            $('#vacancy-info').html('');
        }
    }
    
    // Check vacancies when office or designation changes
    $('#office_id, #designation_id').change(function() {
        checkVacancies();
    });
});
</script>