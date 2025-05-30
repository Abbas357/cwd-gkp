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
        <label for="operational_status">Operational Status</label>
        <select class="form-select" id="operational_status" name="operational_status" required>
            <option value="">Choose...</option>
            @foreach (category('machinery_operational_status', 'machinery') as $status)
            <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </select>
        @error('operational_status')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="power_source">Power Source</label>
        <select class="form-select" id="power_source" name="power_source" required>
            <option value="">Choose...</option>
            @foreach (category('machinery_power_source', 'machinery') as $power_source)
            <option value="{{ $power_source }}">{{ $power_source }}</option>
            @endforeach
        </select>
        @error('power_source')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="manufacturer">Manufacturer</label>
        <select class="form-select" id="manufacturer" name="manufacturer" required>
            <option value="">Choose...</option>
            @foreach (category('machinery_manufacturer', 'machinery') as $manufacturer)
            <option value="{{ $manufacturer }}">{{ $manufacturer }}</option>
            @endforeach
        </select>
        @error('manufacturer')
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
        <label for="manufacturing_year">Manufacturing Year</label>
        <input type="number" class="form-control" id="manufacturing_year" name="manufacturing_year" min="1900" max="{{ date('Y')+1 }}">
        @error('manufacturing_year')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="serial_number">Serial Number*</label>
        <input type="text" class="form-control" id="serial_number" name="serial_number" required>
        @error('serial_number')
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
        <label for="certification_status">Certification Status</label>
        <select class="form-select" id="certification_status" name="certification_status">
            <option value="">Choose...</option>
            @foreach (category('machinery_certification_status', 'machinery') as $status)
            <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </select>
        @error('certification_status')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="last_maintenance_date">Last Maintenance Date</label>
        <input type="date" class="form-control" id="last_maintenance_date" name="last_maintenance_date">
        @error('last_maintenance_date')
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