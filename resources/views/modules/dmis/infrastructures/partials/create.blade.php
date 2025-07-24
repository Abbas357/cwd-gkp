<div class="row" id="step-1">
    <div class="col-md-{{ auth_user()->districts()->count() > 1 ? '6' : '12' }} mb-3">
        <label for="type">Infrastructure Type</label>
        <select class="form-control" id="type" name="type" required>
            <option value="">Select Type</option>
            @foreach(setting('infrastructure_type','dmis') as $infrastructure_type)
            <option value="{{ $infrastructure_type }}">{{ $infrastructure_type }}</option>
            @endforeach
        </select>
        @error('type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    @if(auth_user()->districts()->count() > 1)
        <div class="col-md-6 mb-3">
            <label for="district_id">Districts</label>
            <select class="form-control" id="district_id" name="district_id" required>
                <option value="">Select District</option>
                @foreach($cat['districts'] as $district)
                <option value="{{ $district->id }}">{{ $district->name }}</option>
                @endforeach
            </select>
            @error('district_id')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    @endif

    <div class="col-md-6 mb-3">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="length">Length <small class="text-danger fw-bold infrastructure-type"></small></label>
        <input type="number" class="form-control" id="length" name="length" value="{{ old('length') }}" required>
        @error('length')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row" id="step-2">

    <div class="col-md-6 mb-3">
        <label for="east_start_coordinate">Start Coordinate (Easting)</label>
        <input type="text" class="form-control" id="east_start_coordinate" name="east_start_coordinate" value="{{ old('east_start') }}">
        @error('east_start_coordinate')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="north_start_coordinate">Start Coordinate (Northing)</label>
        <input type="text" class="form-control" id="north_start_coordinate" name="north_start_coordinate" value="{{ old('north_start') }}">
        @error('north_start_coordinate')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="east_end_coordinate">End Coordinate (Easting)</label>
        <input type="text" class="form-control" id="east_end_coordinate" name="east_end_coordinate" value="{{ old('east_end') }}">
        @error('east_end_coordinate')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="north_end_coordinate">End Coordinate (Northing)</label>
        <input type="text" class="form-control" id="north_end_coordinate" name="north_end_coordinate" value="{{ old('north_end') }}">
        @error('north_end_coordinate')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<script>
    $('#type').on('change', function() {        
        const selectedType = $(this).val();
        var selectedTypeMeasurement = selectedType === "Road" ? "(in Kilometers)" : '(in Meters)';
        $('.infrastructure-type').text(selectedTypeMeasurement);
    });
</script>