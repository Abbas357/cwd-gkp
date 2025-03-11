<div class="row">
    <div class="col-md-12 mb-3">
        <label for="office_id">Office <span class="text-danger">*</span></label>
        <select class="form-select" id="office_id" name="office_id" required>
            <option value="">Select Office</option>
            @foreach($data['offices'] as $office)
            <option value="{{ $office->id }}">{{ $office->name }}</option>
            @endforeach
        </select>
        @error('office_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="designation_id">Designation <span class="text-danger">*</span></label>
        <select class="form-select" id="designation_id" name="designation_id" required>
            <option value="">Select Designation</option>
            @foreach($data['designations'] as $designation)
            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
            @endforeach
        </select>
        @error('designation_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="total_positions">Total Positions <span class="text-danger">*</span></label>
        <input type="number" min="1" class="form-control" id="total_positions" name="total_positions" required>
        @error('total_positions')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="status">Status</label>
        <select class="form-select" id="status" name="status">
            <option value="Active" selected>Active</option>
            <option value="Inactive">Inactive</option>
        </select>
        @error('status')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#office_id, #designation_id').select2({
            theme: "bootstrap-5"
            , width: '100%'
            , placeholder: 'Select option'
            , dropdownParent: $('#office_id').closest('.modal')
        });
    });

</script>
