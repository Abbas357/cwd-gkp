<div class="row" id="step-1">
    <div class="col-md-6 mb-3">
        <label for="type">Machinery Type</label>
        <select class="form-select" id="type" name="type" required>
            <option value="">Choose...</option>
            @foreach (category('machinery_type', 'machinery') as $type)
            <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>
        @error('type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="functional_status">Operational Status</label>
        <select class="form-select" id="functional_status" name="functional_status" required>
            <option value="">Choose...</option>
            @foreach (category('machinery_functional_status', 'machinery') as $status)
            <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </select>
        @error('functional_status')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="registration_number">Power Source</label>
        <select class="form-select" id="registration_number" name="registration_number" required>
            <option value="">Choose...</option>
            @foreach (category('machinery_power_source', 'machinery') as $registration_number)
            <option value="{{ $registration_number }}">{{ $registration_number }}</option>
            @endforeach
        </select>
        @error('registration_number')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="brand">Manufacturer</label>
        <select class="form-select" id="brand" name="brand" required>
            <option value="">Choose...</option>
            @foreach (category('machinery_manufacturer', 'machinery') as $brand)
            <option value="{{ $brand }}">{{ $brand }}</option>
            @endforeach
        </select>
        @error('brand')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row" id="step-2">
    <div class="col-md-6 mb-3">
        <label for="model">Model*</label>
        <input type="text" class="form-control" id="model" name="model" required>
        @error('model')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="model_year">Manufacturing Year</label>
        <input type="number" class="form-control" id="model_year" name="model_year" min="1900" max="{{ date('Y')+1 }}">
        @error('model_year')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="engine_number">Serial Number*</label>
        <input type="text" class="form-control" id="engine_number" name="engine_number" required>
        @error('engine_number')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="location">Location</label>
        <select class="form-select" id="location" name="location">
            <option value="">Choose...</option>
            @foreach (category('machinery_location', 'machinery') as $location)
            <option value="{{ $location }}">{{ $location }}</option>
            @endforeach
        </select>
        @error('location')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="chassis_number">Certification Status</label>
        <select class="form-select" id="chassis_number" name="chassis_number">
            <option value="">Choose...</option>
            @foreach (category('machinery_certification_status', 'machinery') as $status)
            <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </select>
        @error('chassis_number')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="fuel_type">Last Maintenance Date</label>
        <input type="date" class="form-control" id="fuel_type" name="fuel_type">
        @error('fuel_type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row" id="step-3">
    <div class="col-md-6 mb-3">
        <label for="front_view">Front View</label>
        <input type="file" class="form-control" id="front_view" name="front_view">
    </div>
    <div class="col-md-6 mb-3">
        <label for="side_view">Side View</label>
        <input type="file" class="form-control" id="side_view" name="side_view">
    </div>
    <div class="col-md-6 mb-3">
        <label for="control_panel">Control Panel</label>
        <input type="file" class="form-control" id="control_panel" name="control_panel">
    </div>
    <div class="col-md-6 mb-3">
        <label for="nameplate">Nameplate/Serial Number</label>
        <input type="file" class="form-control" id="nameplate" name="nameplate">
    </div>
    <div class="col-md-6 mb-3">
        <label for="certification_doc">Certification Document</label>
        <input type="file" class="form-control" id="certification_doc" name="certification_doc">
    </div>
    <div class="col-md-6 mb-3">
        <label for="manual">Operation Manual</label>
        <input type="file" class="form-control" id="manual" name="manual" accept=".pdf,.doc,.docx">
    </div>
</div>

<div class="row" id="step-4">
    <div class="col-md-12 mb-3">
        <label for="specifications">Technical Specifications</label>
        <textarea class="form-control" id="specifications" name="specifications" rows="2"></textarea>
        @error('specifications')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-12 mb-3">
        <label for="remarks">Remarks</label>
        <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
        @error('remarks')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>