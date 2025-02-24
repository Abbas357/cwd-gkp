<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="type">Type</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="">Choose...</option>
                    @foreach ($cat['vehicle_type'] as $type)
                    <option value="{{ $type->name }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('type')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="functional_status">Functional Status</label>
                <select class="form-select" id="functional_status" name="functional_status" required>
                    <option value="">Choose...</option>
                    @foreach ($cat['vehicle_functional_status'] as $functional_status)
                    <option value="{{ $functional_status->name }}">{{ $functional_status->name }}</option>
                    @endforeach
                </select>
                @error('functional_status')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="color">Color</label>
                <select class="form-select" id="color" name="color" required>
                    <option value="">Choose...</option>
                    @foreach ($cat['vehicle_color'] as $color)
                    <option value="{{ $color->name }}">{{ $color->name }}</option>
                    @endforeach
                </select>
                @error('color')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="registration_number">Registration Number*</label>
                <input type="text" class="form-control @error('registration_number') is-invalid @enderror" id="registration_number" name="registration_number" value="{{ old('registration_number') }}" required>
                @error('registration_number')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="fuel_type">Fuel Type</label>
                <select class="form-select" id="fuel_type" name="fuel_type" required>
                    <option value="">Choose...</option>
                    @foreach ($cat['fuel_type'] as $fuel_type)
                    <option value="{{ $fuel_type->name }}">{{ $fuel_type->name }}</option>
                    @endforeach
                </select>
                @error('fuel_type')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="brand">Brand</label>
                <select class="form-select" id="brand" name="brand" required>
                    <option value="">Choose...</option>
                    @foreach ($cat['vehicle_brand'] as $brand)
                    <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
                @error('brand')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="model">Model*</label>
                <input type="text" class="form-control @error('model') is-invalid @enderror" id="model" name="model" value="{{ old('model') }}" required>
                @error('model')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="model_year">Model Year</label>
                <input type="number" class="form-control @error('model_year') is-invalid @enderror" id="model_year" name="model_year" value="{{ old('model_year') }}" min="1900" max="{{ date('Y')+1 }}">
                @error('model_year')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="registration_status">Registration Status</label>
                <select class="form-select" id="registration_status" name="registration_status" required>
                    <option value="">Choose...</option>
                    @foreach ($cat['vehicle_registration_status'] as $registration_status)
                    <option value="{{ $registration_status->name }}">{{ $registration_status->name }}</option>
                    @endforeach
                </select>
                @error('registration_status')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="chassis_number">Chassis Number</label>
                <input type="text" class="form-control @error('chassis_number') is-invalid @enderror" id="chassis_number" name="chassis_number" value="{{ old('chassis_number') }}">
                @error('chassis_number')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="engine_number">Engine Number</label>
                <input type="text" class="form-control @error('engine_number') is-invalid @enderror" id="engine_number" name="engine_number" value="{{ old('engine_number') }}">
                @error('engine_number')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="images">Images</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple>
                @error('images')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12 mb-3">
                <label for="remarks">Remarks</label>
                <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                @error('remarks')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>
    </div>
</div>
