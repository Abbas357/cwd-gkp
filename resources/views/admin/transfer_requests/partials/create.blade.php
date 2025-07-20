<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">

<div class="row">
    <div class="col-md-12 mb-3">
        <label for="to_designation_id">To Designation</label>
        <select class="form-select form-select-md" id="to_designation_id" name="to_designation_id" required>
            <option value="">Select Designation</option>
            @foreach ($designations as $designation)
                <option value="{{ $designation->id }}"> {{ $designation->name }} </option>
            @endforeach
        </select>
        <small class="form-text">Please select your current designation.</small>
    </div>

    <div class="col-md-12 mb-3">
        <label for="to_office_id">To Office</label>
        <select class="form-select form-select-md" id="to_office_id" name="to_office_id" required>
            <option value="">Select Office</option>
            @foreach ($offices as $office)
                <option value="{{ $office->id }}"> {{ $office->name }} </option>
            @endforeach
        </select>
        <small class="form-text">Please select the office you are currently posted.</small>
    </div>

    <div class="col-md-12 mb-3">
        <label for="posting_date">Date of Posting</label>
        <input type="date" class="form-control" id="posting_date" value="{{ old('posting_date') }}"
            placeholder="Start Date & Time" name="posting_date" required>
        @error('posting_date')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <small class="form-text">Date when you were transferred.</small>
    </div>

    <div class="col-md-12 mb-3">
        <label for="remarks">Remarks</label>
        <input type="text" class="form-control" id="remarks" value="{{ old('remarks') }}"
            placeholder="Remarks" name="remarks">
        @error('remarks')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <small class="form-text">Add any additional remarks regarding the transfer (optional).</small>
    </div>
</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
<script>
    $('#to_office_id').select2({
        theme: "bootstrap-5",
        width: '100%',
        placeholder: 'Select option',
        closeOnSelect: true,
        dropdownParent: $('#to_office_id').closest('.modal'),
    });

    $('#to_designation_id').select2({
        theme: "bootstrap-5",
        width: '100%',
        placeholder: 'Select option',
        closeOnSelect: true,
        dropdownParent: $('#to_designation_id').closest('.modal'),
    });
</script>
