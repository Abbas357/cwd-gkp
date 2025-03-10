<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">

<div class="row" id="step-1">
    <div class="col-md-6 mb-3">
        <label for="user_id">User</label>
        <select class="form-select" id="user_id" name="user_id" required>
            <option value="">Select User</option>
            @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
        @error('user_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="type">Posting Type</label>
        <select class="form-select" id="type" name="type" required>
            <option value="">Select Type</option>
            @foreach ($postingTypes as $type)
            <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>
        @error('type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="office_id">Office</label>
        <select class="form-select" id="office_id" name="office_id" required>
            <option value="">Select Office</option>
            @foreach ($offices as $office)
            <option value="{{ $office->id }}">{{ $office->name }}</option>
            @endforeach
        </select>
        @error('office_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="designation_id">Designation</label>
        <select class="form-select" id="designation_id" name="designation_id" required>
            <option value="">Select Designation</option>
            @foreach ($designations as $designation)
            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
            @endforeach
        </select>
        @error('designation_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <div id="sanctioned-post-status" class="alert alert-info d-none">
            Please select an office and designation to check sanctioned post availability.
        </div>
    </div>

</div>

<div class="row" id="step-2">
    <div class="col-md-6 mb-3">
        <label for="start_date">Start Date</label>
        <input type="date" class="form-control" id="start_date" name="start_date" required>
        @error('start_date')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="posting_order">Posting Order</label>
        <input type="file" class="form-control" id="posting_order" name="posting_order">
        @error('posting_order')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="order_number">Order Number</label>
        <input type="text" class="form-control" id="order_number" name="order_number">
        @error('order_number')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

</div>

<div class="row" id="step-3">

    <div class="col-md-12 mb-3">
        <label for="remarks">Remarks</label>
        <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
        @error('remarks')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="end_current" name="end_current" checked>
            <label class="form-check-label" for="end_current">
                End current posting of this user (if any)
            </label>
        </div>
    </div>
    
</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#user_id').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: 'Select option',
            dropdownParent: $('#user_id').closest('.modal')
        });

        $('#office_id').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: 'Select option',
            dropdownParent: $('#office_id').closest('.modal')
        });
        
        $('#designation_id').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: 'Select option',
            dropdownParent: $('#designation_id').closest('.modal')
        });

        function checkSanctionedPost() {
            const officeId = $('#office_id').val();
            const designationId = $('#designation_id').val();
            const statusDiv = $('#sanctioned-post-status');

            if (!officeId || !designationId) {
                statusDiv.addClass('d-none');
                return;
            }

            statusDiv.removeClass('d-none alert-success alert-danger alert-warning').addClass('alert-info');
            statusDiv.html('Checking sanctioned post availability...');

            $.ajax({
                url: "{{ route('admin.apps.hr.postings.check-sanctioned') }}"
                , method: 'POST'
                , data: {
                    office_id: officeId
                    , designation_id: designationId
                    , _token: "{{ csrf_token() }}"
                }
                , success: function(response) {
                    statusDiv.removeClass('alert-info');

                    if (response.valid) {
                        statusDiv.addClass('alert-success');
                        statusDiv.html(`
                            <strong>Sanctioned post available</strong><br>
                            Total sanctioned positions: ${response.sanctioned}<br>
                            Filled positions: ${response.filled}<br>
                            Available positions: ${response.available}
                        `);
                    } else {
                        if (response.sanctioned) {
                            statusDiv.addClass('alert-danger');
                            statusDiv.html(`
                                <strong>No sanctioned post available</strong><br>
                                Total sanctioned positions: ${response.sanctioned}<br>
                                Filled positions: ${response.filled}<br>
                                Available positions: ${response.available}
                            `);
                        } else {
                            statusDiv.addClass('alert-warning');
                            statusDiv.html(`
                                <strong>Warning</strong><br>
                                ${response.message}
                            `);
                        }
                    }
                }
                , error: function() {
                    statusDiv.removeClass('alert-info').addClass('alert-danger');
                    statusDiv.html('Error checking sanctioned post availability.');
                }
            });
        }

        // Check sanctioned post when office or designation changes
        $('#office_id, #designation_id').change(checkSanctionedPost);
    });

</script>