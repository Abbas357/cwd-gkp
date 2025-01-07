<x-main-layout>
    @push('style')
    <style>
        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            color: #0d6efd;
            font-weight: 600;
        }
        .top-nav-container {
            background: #f8f9fa;
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 2rem;
        }
        .form-label {
            font-weight: bold;
            color: #666;
        }
    </style>
    @endpush

    @include('site.cont_registrations.partials.header')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Edit Registration</h2>
        </div>

        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('registrations.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="card mb-4">
                <div class="card-header bg-light">
                    Personal Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Owner Name</label>
                                <input type="text" class="form-control" name="owner_name" value="{{ old('owner_name', $contractor->owner_name) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contractor Name</label>
                                <input type="text" class="form-control" name="contractor_name" value="{{ old('contractor_name', $contractor->contractor_name) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" name="mobile_number" value="{{ old('mobile_number', $contractor->mobile_number) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CNIC</label>
                                <input type="text" class="form-control" name="cnic" value="{{ old('cnic', $contractor->cnic) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $contractor->email) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">District</label>
                                <input type="text" class="form-control" name="district" value="{{ old('district', $contractor->district) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" rows="3">{{ old('address', $contractor->address) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    Professional Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">PEC Number</label>
                                <input type="text" class="form-control" name="pec_number" value="{{ old('pec_number', $contractor->pec_number) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">PEC Category</label>
                                <input type="text" class="form-control" name="pec_category" value="{{ old('pec_category', $contractor->pec_category) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category Applied</label>
                                <input type="text" class="form-control" name="category_applied" value="{{ old('category_applied', $contractor->category_applied) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">FBR NTN</label>
                                <input type="text" class="form-control" name="fbr_ntn" value="{{ old('fbr_ntn', $contractor->fbr_ntn) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">KPRA Registration No</label>
                                <input type="text" class="form-control" name="kpra_reg_no" value="{{ old('kpra_reg_no', $contractor->kpra_reg_no) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Is Limited</label>
                                <select class="form-select" name="is_limited">
                                    <option value="no" {{ old('is_limited', $contractor->is_limited) === 'no' ? 'selected' : '' }}>No</option>
                                    <option value="yes" {{ old('is_limited', $contractor->is_limited) === 'yes' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    Attachments
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contractor Picture</label>
                                <input type="file" class="form-control" name="contractor_picture">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CNIC Front</label>
                                <input type="file" class="form-control" name="cnic_front_attachment">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CNIC Back</label>
                                <input type="file" class="form-control" name="cnic_back_attachment">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">FBR Attachment</label>
                                <input type="file" class="form-control" name="fbr_attachment">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">KPRA Attachment</label>
                                <input type="file" class="form-control" name="kpra_attachment">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">PEC Attachment</label>
                                <input type="file" class="form-control" name="pec_attachment">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('registrations.dashboard') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Registration</button>
            </div>
        </form>
    </div>
</x-main-layout>