<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">

<div class="row" id="step-1">
    <div class="col-md-6 mb-3">
        <label for="type">Type</label>
        <select class="form-select" id="type" name="type" required>
            <option value="">Choose...</option>
            @foreach (category('type', 'machinery') as $type)
            <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>
        @error('type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="functional_status">Functional Status</label>
        <select class="form-select" id="functional_status" name="functional_status" required>
            <option value="">Choose...</option>
            @foreach ($statuses as $status)
            <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </select>
        @error('functional_status')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="brand">Brand</label>
        <select class="form-select" id="brand" name="brand" required>
            <option value="">Choose...</option>
            @foreach (category('brand', 'machinery') as $brand)
            <option value="{{ $brand }}">{{ $brand }}</option>
            @endforeach
        </select>
        @error('brand')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="model">Model</label>
        <input type="text" class="form-control" id="model" name="model" min="1900">
        @error('model')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="model_year">Model Year</label>
        <input type="number" class="form-control" id="model_year" name="model_year" min="1900" max="{{ date('Y')+1 }}">
        @error('model_year')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="fuel_type">Fuel Type</label>
        <select class="form-select" id="fuel_type" name="fuel_type" required>
            <option value="">Choose...</option>
            @foreach ($fuel_types as $fuel_type)
            <option value="{{ $fuel_type }}">{{ $fuel_type }}</option>
            @endforeach
        </select>
        @error('fuel_type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row" id="step-2">
    
    <div class="col-md-6 mb-3">
        <label for="engine_number">Engine Number*</label>
        <input type="text" class="form-control" id="engine_number" name="engine_number">
        @error('engine_number')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="chassis_number">Chassis Number</label>
        <input type="text" class="form-control" id="chassis_number" name="chassis_number">
        @error('chassis_number')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="registration_number">Registration Number</label>
        <input type="text" class="form-control" id="registration_number" name="registration_number">
        @error('registration_number')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="remarks">Remarks</label>
        <input type="text" class="form-control" id="remarks" name="remarks">
        @error('remarks')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="front_view">Front View Picture</label>
        <input type="file" class="form-control" id="front_view" name="front_view">
    </div>

    <div class="col-md-6 mb-3">
        <label for="side_view">Side View Picture</label>
        <input type="file" class="form-control" id="side_view" name="side_view">
    </div>
    
</div>

<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script>
    $(document).ready(function() {
        imageCropper({
            fileInput: '#front_view'
            , aspectRatio: 3 / 2
        });

        imageCropper({
            fileInput: '#side_view'
            , aspectRatio: 3 / 2
        });
    });
</script>