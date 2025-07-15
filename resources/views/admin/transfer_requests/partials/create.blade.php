<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="load-offices">To Office</label>
        <select class="form-select form-select-md" id="load-offices" name="to_office">
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="load-offices">To Designation</label>
        <select class="form-select form-select-md" id="load-offices" name="to_designation">
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="posting_date">Date of Posting</label>
        <input type="date" class="form-control" id="posting_date" value="{{ old('posting_date') }}" placeholder="Start Date & Time" name="posting_date" required>
        @error('posting_date')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>


<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        select2Ajax(
            '#load-offices',
            '{{ route("admin.apps.hr.offices.api") }}',
            {
                placeholder: "Select User / Office",
                dropdownParent: $('#load-offices').closest('.modal')
            }
        );

    });

</script>
