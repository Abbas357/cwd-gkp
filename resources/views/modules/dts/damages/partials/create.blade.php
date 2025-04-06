<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
<!-- Step 1: Basic Information -->
<div class="row" id="step-1">
    <div class="col-md-6 mb-3">
        <label for="report_date">Report Date</label>
        <input type="date" class="form-control" id="report_date" name="report_date" value="{{ old('report_date') }}" required>
        @error('report_date')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="type">Type</label>
        <select class="form-control" id="type" name="type" required>
            <option value="">Select Type</option>
            @foreach(setting('infrastructure_type', 'dts') as $type)
            <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>
        @error('type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="load-infrastructures">Infrastructures</label>
        <select class="form-select form-select-md" id="load-infrastructures" name="infrastructure_id">
        </select>
        <small class="form-text text-muted">
            <a href="{{ route('admin.apps.dts.infrastructures.index', ['create' => 'true', 'popup' => 'true']) }}" 
               onclick="openPopup(event, this.href)">Create</a> new if not available
        </small>        
    </div>
</div>

<!-- Step 2: Damage Information -->
<div class="row" id="step-2">
    <div class="col-md-6 mb-3">
        <label for="damaged_length">Damaged Length</label>
        <input type="text" class="form-control" id="damaged_length" name="damaged_length" value="{{ old('damaged_length') }}">
        @error('damaged_length')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="damage_nature">Damage Nature</label>
        <select class="form-control h-50" id="damage_nature" name="damage_nature[]" multiple>
            @foreach(setting('damage_nature', 'dts') as $nature)
            <option value="{{ $nature }}">{{ $nature }}</option>
            @endforeach
        </select>
        @error('damage_nature')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="damage_status">Damage Status</label>
        <select class="form-control" id="damage_status" name="damage_status" required>
            <option value="">Select Damage Status</option>
            @foreach(setting('damage_status', 'dts') as $damage_status)
            <option value="{{ $damage_status }}">{{ $damage_status }}</option>
            @endforeach
        </select>
        @error('damage_status')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="road_status">Road Status</label>
        <select class="form-control" id="road_status" name="road_status" required>
            <option value="">Select Road Status</option>
            @foreach(setting('road_status', 'dts') as $road_status)
            <option value="{{ $road_status }}">{{ $road_status }}</option>
            @endforeach
        </select>
        @error('road_status')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Step 3: Damage Coordinates -->
<div class="row" id="step-3">
    <div class="col-md-6 mb-3">
        <label for="damage_east_start">Damage Start Coordinate (Easting)</label>
        <input type="text" class="form-control" id="damage_east_start" name="damage_east_start" value="{{ old('damage_east_start') }}">
        @error('damage_east_start')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="damage_north_start">Damage Start Coordinate (Northing)</label>
        <input type="text" class="form-control" id="damage_north_start" name="damage_north_start" value="{{ old('damage_north_start') }}">
        @error('damage_north_start')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="damage_east_end">Damage End Coordinate (Easting)</label>
        <input type="text" class="form-control" id="damage_east_end" name="damage_east_end" value="{{ old('damage_east_end') }}">
        @error('damage_east_end')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="damage_north_end">Damage End Coordinate (Northing)</label>
        <input type="text" class="form-control" id="damage_north_end" name="damage_north_end" value="{{ old('damage_north_end') }}">
        @error('damage_north_end')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Step 4: Cost and Additional Info -->
<div class="row" id="step-4">
    <div class="col-md-6 mb-3">
        <label for="approximate_restoration_cost">Approximate Restoration Cost (Millions)</label>
        <input type="text" class="form-control" id="approximate_restoration_cost" name="approximate_restoration_cost" value="{{ old('approximate_restoration_cost') }}" required>
        @error('approximate_restoration_cost')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="approximate_rehabilitation_cost">Approximate Rehabilitation Cost (Millions)</label>
        <input type="text" class="form-control" id="approximate_rehabilitation_cost" name="approximate_rehabilitation_cost" value="{{ old('approximate_rehabilitation_cost') }}" required>
        @error('approximate_rehabilitation_cost')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="remarks">Remarks</label>
        <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
        @error('remarks')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Step 5: Images -->
<div class="row" id="step-5">
    <div class="col-md-6 mb-3">
        <label for="before_images">Before Images</label>
        <input type="file" class="form-control" id="before_images" name="before_images[]" multiple accept="image/*">
        <small class="form-text text-muted">You can select multiple images</small>
        @error('before_images')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="after_images">After Images</label>
        <input type="file" class="form-control" id="after_images" name="after_images[]" multiple accept="image/*">
        <small class="form-text text-muted">You can select multiple images</small>
        @error('after_images')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-12 mb-3">
        <div class="row" id="before_images_preview">
            <!-- Before images preview will be displayed here -->
        </div>
        <div class="row" id="after_images_preview">
            <!-- After images preview will be displayed here -->
        </div>
    </div>
</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>

<script>

    $('#type').on('change', function() {
        const selectedType = $(this).val();
        
        $('#load-infrastructures').val(null).empty();
        
        select2Ajax(
            '#load-infrastructures',
            '{{ route("admin.apps.dts.infrastructures.api") }}',
            {
                placeholder: "Select Infrastructure",
                dropdownParent: $('#load-infrastructures').closest('.modal'),
                params: {
                    type: selectedType
                }
            }
        );
    });

    select2Ajax(
        '#load-infrastructures',
        '{{ route("admin.apps.dts.infrastructures.api") }}',
        {
            placeholder: "Select Infrastructure",
            dropdownParent: $('#load-infrastructures').closest('.modal')
        }
    );

    $('#damage_nature').select2({
        theme: "bootstrap-5" 
        , width: '100%'
        , placeholder: 'Select Featured On'
        , closeOnSelect: true
        , dropdownParent: $('#damage_nature').closest('.modal')
    , });

    function openPopup(event, url) {
        event.preventDefault();
        window.open(
            url, 
            "popupWindow", 
            "width=1000,height=800,scrollbars=no,resizable=no"
        );
    }

</script>