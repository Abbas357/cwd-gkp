<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
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
            @foreach($cat['infrastructure_type'] as $type)
            <option value="{{ $type }}">{{ $type }}</option>
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
    
    <div class="col-md-{{ auth_user()->districts()->count() > 1 ? '6' : '12' }} mb-3">
        <label for="load-infrastructures">Infrastructures</label>
        <select class="form-select form-select-md" id="load-infrastructures" name="infrastructure_id" required></select>
        <p class="form-text text-muted m-2">
            <span class="fw-bold">If not available,</span>
            <a class="btn btn-sm btn-outline-success ms-1" 
               href="{{ route('admin.apps.dmis.infrastructures.index', ['create' => 'true', 'popup' => 'true']) }}" 
               onclick="openPopup(event, this.href)">
                + Create New Infrastructure
            </a>
        </p>       
    </div>

</div>

<!-- Step 2: Damage Information -->
<div class="row" id="step-2">
    <div class="col-md-6 mb-3">
        <label for="damaged_length">Damaged Length <small class="text-danger fw-bold infrastructure-type" style="font-size:18px"></small></label>
        <input type="text" class="form-control" id="damaged_length" placeholder="Note: Road = Kilometer & Bridge/Culverts = Meters" name="damaged_length" value="{{ old('damaged_length') }}">
        @error('damaged_length')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="damage_nature">Damage Nature</label>
        <select class="form-control h-50" id="damage_nature" name="damage_nature[]" multiple>
            @foreach(category('damage_nature', 'dmis') as $nature)
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
            @foreach($cat['damage_status'] as $damage_status)
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
            @foreach($cat['road_status'] as $road_status)
            <option value="{{ $road_status }}">{{ $road_status }}</option>
            @endforeach
        </select>
        @error('road_status')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <hr>
    <h4>Coordinates</h4>

    <div class="col-md-4 mb-3">
        <label for="damage_north_start">Start Northing <span class="fw-bold">(Latitude)</span></label>
        <input type="text" class="form-control" id="damage_north_start" name="damage_north_start" placeholder="eg 34.646253" value="{{ old('damage_north_start') }}">
        @error('damage_north_start')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-4 mb-3">
        <label for="damage_east_start">Start Easting <span class="fw-bold">(Longitude)</span></label>
        <input type="text" class="form-control" id="damage_east_start" name="damage_east_start" placeholder="eg 72.629942" value="{{ old('damage_east_start') }}">
        @error('damage_east_start')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-4 mb-3">
        <label for="damage_north_end">End Northing <span class="fw-bold">(Latitude)</span></label>
        <input type="text" class="form-control" id="damage_north_end" name="damage_north_end" placeholder="eg 34.644727" value="{{ old('damage_north_end') }}">
        @error('damage_north_end')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-4 mb-3">
        <label for="damage_east_end">End Easting <span class="fw-bold">(Longitude)</span></label>
        <input type="text" class="form-control" id="damage_east_end" name="damage_east_end" placeholder="eg 72.952492" value="{{ old('damage_east_end') }}">
        @error('damage_east_end')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
</div>

<!-- Step 4: Cost and Additional Info -->
<div class="row" id="step-3">
    <div class="col-md-6 mb-3">
        <label for="approximate_restoration_cost">Approximate Restoration Cost <small class="text-danger fw-bold" style="font-size:18px">(Millions)</small></label>
        <input type="text" class="form-control" id="approximate_restoration_cost" name="approximate_restoration_cost" placeholder="Enter amount in millions (e.g., 2.3)" value="{{ old('approximate_restoration_cost') }}" required>
        @error('approximate_restoration_cost')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="approximate_rehabilitation_cost">Approximate Rehabilitation Cost <small class="text-danger fw-bold" style="font-size:18px">(Millions)</small></label>
        <input type="text" class="form-control" id="approximate_rehabilitation_cost" name="approximate_rehabilitation_cost" placeholder="Enter amount in millions (e.g., 3.7)" value="{{ old('approximate_rehabilitation_cost') }}" required>
        @error('approximate_rehabilitation_cost')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="remarks">Remarks</label>
        <input type="text" class="form-control" id="remarks" placeholder="Additional Info (If any)" name="remarks" value="{{ old('remarks') }}" />
        @error('remarks')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="before_images">Before Images</label>
        <input type="file" class="form-control" id="before_images" name="damage_before_images[]" multiple accept="image/*">
        <small class="form-text text-danger">Please select only 1, 2, or 3 images.</small>
        @error('before_images')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <div id="before-preview-container"></div>
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="after_images">After Images</label>
        <input type="file" class="form-control" id="after_images" name="damage_after_images[]" multiple accept="image/*">
        <small class="form-text text-danger">Please select only 1, 2, or 3 images.</small>
        @error('after_images')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <div id="after-preview-container"></div>
    </div>
</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script>

    $(document).ready(function() {

        imageCropper({
            fileInput: "#before_images",
            aspectRatio: 3 / 2,
            minFileSizeInKB: 150,
            maxFileSizeInKB: 100,
            maxQualityAttempts: 15,
            quality: 0.5,
        });

        imageCropper({
            fileInput: "#after_images",
            aspectRatio: 3 / 2,
            minFileSizeInKB: 150,
            maxFileSizeInKB: 100,
            maxQualityAttempts: 15,
            quality: 0.5,
        });

        $('#before_images, #after_images').on('change', function() {
            if (this.files.length > 3) {
                showNotification("Warning! Only the first 3 images will be uploaded", "info", {timer: 5000});
                const dt = new DataTransfer();
                for (let i = 0; i < 3; i++) {
                    dt.items.add(this.files[i]);
                }
                this.files = dt.files;
            }
        });
    });

    $('#type, #district_id').on('change', function() {
        $('#load-infrastructures').val(null).empty();
        
        const selectedType = $('#type').val();
        const selectedDistrictId = $('#district_id').val();
        
        var selectedTypeMeasurement = selectedType === "Road" ? "(in Kilometers)" : '(in Meters)';
        $('.infrastructure-type').text(selectedTypeMeasurement);
        
        const params = {};
        
        if (selectedType && selectedType !== '') {
            params.type = selectedType;
        }
        
        if (selectedDistrictId && selectedDistrictId !== '') {
            params.district_id = selectedDistrictId;
        }
        
        select2Ajax(
            '#load-infrastructures',
            '{{ route("admin.apps.dmis.infrastructures.api") }}',
            {
                placeholder: "Select Infrastructure",
                dropdownParent: $('#load-infrastructures').closest('.modal'),
                params: params
            }
        );
    });
    
    $('#district_id').select2({
        theme: "bootstrap-5" 
        , width: '100%'
        , placeholder: 'Select District'
        , dropdownParent: $('#district_id').closest('.modal')
    });

    $('#damage_nature').select2({
        theme: "bootstrap-5" 
        , width: '100%'
        , placeholder: 'Select Featured On'
        , closeOnSelect: false
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