<x-app-layout title="Add Vehicle">
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Add Vehicle</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.vehicles.store') }}" method="post" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title pb-4">Add Vehicle</h3>
                                <a class="btn btn-success shadow-sm" href="{{ route('admin.vehicles.index') }}">All Vehicles</a>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label for="registration_number">Registration Number*</label>
                                    <input type="text" class="form-control @error('registration_number') is-invalid @enderror" 
                                           id="registration_number" name="registration_number" value="{{ old('registration_number') }}" required>
                                    @error('registration_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="type">Vehicle Type</label>
                                    <input type="text" class="form-control @error('type') is-invalid @enderror" 
                                           id="type" name="type" value="{{ old('type') }}">
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="brand">Brand*</label>
                                    <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                           id="brand" name="brand" value="{{ old('brand') }}" required>
                                    @error('brand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="model">Model*</label>
                                    <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                           id="model" name="model" value="{{ old('model') }}" required>
                                    @error('model')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="model_year">Model Year</label>
                                    <input type="number" class="form-control @error('model_year') is-invalid @enderror" 
                                           id="model_year" name="model_year" value="{{ old('model_year') }}" 
                                           min="1900" max="{{ date('Y')+1 }}">
                                    @error('model_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="color">Color</label>
                                    <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                           id="color" name="color" value="{{ old('color') }}">
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="fuel_type">Fuel Type*</label>
                                    <select class="form-select @error('fuel_type') is-invalid @enderror" 
                                            id="fuel_type" name="fuel_type" required>
                                        <option value="">Select Fuel Type</option>
                                        <option value="petrol" {{ old('fuel_type') == 'petrol' ? 'selected' : '' }}>Petrol</option>
                                        <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                        <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                                    </select>
                                    @error('fuel_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="functional_status">Functional Status</label>
                                    <select class="form-select @error('functional_status') is-invalid @enderror" 
                                            id="functional_status" name="functional_status">
                                        <option value="">Select Status</option>
                                        <option value="operational" {{ old('functional_status') == 'operational' ? 'selected' : '' }}>Operational</option>
                                        <option value="maintenance" {{ old('functional_status') == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                        <option value="repair" {{ old('functional_status') == 'repair' ? 'selected' : '' }}>Needs Repair</option>
                                    </select>
                                    @error('functional_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="registration_status">Registration Status</label>
                                    <select class="form-select @error('registration_status') is-invalid @enderror" 
                                            id="registration_status" name="registration_status">
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('registration_status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="expired" {{ old('registration_status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                        <option value="pending" {{ old('registration_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                    @error('registration_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="chassis_number">Chassis Number</label>
                                    <input type="text" class="form-control @error('chassis_number') is-invalid @enderror" 
                                           id="chassis_number" name="chassis_number" value="{{ old('chassis_number') }}">
                                    @error('chassis_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="engine_number">Engine Number</label>
                                    <input type="text" class="form-control @error('engine_number') is-invalid @enderror" 
                                           id="engine_number" name="engine_number" value="{{ old('engine_number') }}">
                                    @error('engine_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="vehicle_user_id">Assign *</label>
                                    <select class="form-select @error('vehicle_user_id') is-invalid @enderror" 
                                            id="vehicle_user_id" name="vehicle_user_id" required>
                                        <option value="">Select User</option>
                                        @foreach($vehicleUsers as $user)
                                            <option value="{{ $user->id }}" {{ old('vehicle_user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                              id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                                    @error('remarks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-actions mb-4 mt-2">
                                <button class="btn btn-primary btn-block" type="submit">Add Vehicle</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>