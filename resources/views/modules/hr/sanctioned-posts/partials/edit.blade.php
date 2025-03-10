<div class="row">
    <div class="col-md-12 mb-3">
        <label for="office_id">Office <span class="text-danger">*</span></label>
        <select class="form-select" id="office_id" name="office_id" required>
            <option value="">Select Office</option>
            @foreach($data['offices'] as $office)
            <option value="{{ $office->id }}" {{ $data['sanctionedPost']->office_id == $office->id ? 'selected' : '' }}>
                {{ $office->name }}
            </option>
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
            <option value="{{ $designation->id }}" {{ $data['sanctionedPost']->designation_id == $designation->id ? 'selected' : '' }}>
                {{ $designation->name }}
            </option>
            @endforeach
        </select>
        @error('designation_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="total_positions">Total Positions <span class="text-danger">*</span></label>
        <input type="number" min="1" class="form-control" id="total_positions" name="total_positions" value="{{ $data['sanctionedPost']->total_positions }}" required>
        <small class="text-info">Current filled positions: {{ $data['filledPositions'] }}</small>
        @error('total_positions')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="status">Status</label>
        <select class="form-select" id="status" name="status">
            <option value="Active" {{ $data['sanctionedPost']->status === 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Inactive" {{ $data['sanctionedPost']->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title">Summary</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <h4>{{ $data['sanctionedPost']->total_positions }}</h4>
                            <p class="mb-0">Total</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h4>{{ $data['filledPositions'] }}</h4>
                            <p class="mb-0">Filled</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h4>{{ $data['vacancies'] }}</h4>
                            <p class="mb-0">Vacant</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize Select2 for dropdowns
        $('#office_id, #designation_id').select2({
            theme: "bootstrap-5"
            , width: '100%'
            , placeholder: 'Select option'
            , dropdownParent: $('#office_id').closest('.modal-content')
        });
    });

</script>
