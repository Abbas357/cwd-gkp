<div class="row" id=step-1>
    <div class="col-md-6 mb-3">
        <label for="type">Type</label>
        <select class="form-select" id="type" name="type" required>
            <option value="">Choose...</option>
            @foreach ($cat['vehicle_type'] as $type)
            <option value="{{ $type->name }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="color">Color</label>
        <select class="form-select" id="color" name="color" required>
            <option value="">Choose...</option>
            @foreach ($cat['vehicle_color'] as $color)
            <option value="{{ $color->name }}">{{ $color->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="fuel_type">Fuel Type</label>
        <select class="form-select" id="fuel_type" name="fuel_type" required>
            <option value="">Choose...</option>
            @foreach ($cat['fuel_type'] as $fuel_type)
            <option value="{{ $fuel_type->name }}">{{ $fuel_type->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="brand">Brand</label>
        <select class="form-select" id="brand" name="brand" required>
            <option value="">Choose...</option>
            @foreach ($cat['vehicle_brand'] as $brand)
            <option value="{{ $brand->name }}">{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row" id="step-2">
    <div class="col-md-6 mb-3">
        <label for="functional_status">Functional Status</label>
        <select class="form-select" id="functional_status" name="functional_status" required>
            <option value="">Choose...</option>
            @foreach ($cat['vehicle_functional_status'] as $functional_status)
            <option value="{{ $functional_status->name }}">{{ $functional_status->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="registration_status">Registration Status</label>
        <select class="form-select" id="registration_status" name="registration_status" required>
            <option value="">Choose...</option>
            @foreach ($cat['vehicle_registration_status'] as $registration_status)
            <option value="{{ $registration_status->name }}">{{ $registration_status->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label for="model">Model*</label>
        <input type="text" class="form-control" id="model" name="model" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="model_year">Model Year</label>
        <input type="number" class="form-control" id="model_year" name="model_year" min="1900" max="{{ date('Y')+1 }}">
    </div>
</div>

<div class="row" id="step-3">
    <div class="col-md-4 mb-3">
        <label for="registration_number">Registration Number*</label>
        <input type="text" class="form-control" id="registration_number" name="registration_number" required>
    </div>
    <div class="col-md-4 mb-3">
        <label for="chassis_number">Chassis Number</label>
        <input type="text" class="form-control" id="chassis_number" name="chassis_number">
    </div>
    <div class="col-md-4 mb-3">
        <label for="engine_number">Engine Number</label>
        <input type="text" class="form-control" id="engine_number" name="engine_number">
    </div>
    <div class="col-md-12 mb-3">
        <label for="remarks">Remarks</label>
        <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
    </div>
</div>

<div class="row" id="step-4">
    <div class="col-md-6 mb-3">
        <label for="front_view">Front View</label>
        <input type="file" class="form-control" id="front_view" name="front_view">
    </div>
    <div class="col-md-6 mb-3">
        <label for="side_view">Side View</label>
        <input type="file" class="form-control" id="side_view" name="side_view">
    </div>
    <div class="col-md-6 mb-3">
        <label for="rear_view">Rear View</label>
        <input type="file" class="form-control" id="rear_view" name="rear_view">
    </div>
    <div class="col-md-6 mb-3">
        <label for="interior_view">Interior View</label>
        <input type="file" class="form-control" id="interior_view" name="interior_view">
    </div>
</div>