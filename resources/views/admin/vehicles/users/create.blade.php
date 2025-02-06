<x-app-layout title="Add Vehicle User">
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Add Vehicle User</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.vehicle-users.store') }}" method="post" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title pb-4">Add Vehicle User</h3>
                                <a class="btn btn-success shadow-sm" href="{{ route('admin.vehicle-users.index') }}">All Vehicle Users</a>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label for="name">Name*</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="designation">Designation</label>
                                    <select class="form-select" id="designation" name="designation" required>
                                        <option value="">Choose...</option>
                                        @foreach ($designations as $designation)
                                        <option value="{{ $designation->name }}">{{ $designation->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('designation')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="office">Office</label>
                                    <select class="form-select" id="office" name="office" required>
                                        <option value="">Choose...</option>
                                        @foreach ($offices as $office)
                                        <option value="{{ $office->name }}">{{ $office->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('office')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="office_type">Office Type*</label>
                                    <select class="form-select @error('office_type') is-invalid @enderror" 
                                            id="office_type" name="office_type" required>
                                        <option value="">Select Office Type</option>
                                        <option value="division" {{ old('office_type') == 'division' ? 'selected' : '' }}>Division</option>
                                        <option value="circle" {{ old('office_type') == 'circle' ? 'selected' : '' }}>Circle</option>
                                    </select>
                                    @error('office_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-actions mb-4 mt-2">
                                <button class="btn btn-primary btn-block" type="submit">Add User</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>