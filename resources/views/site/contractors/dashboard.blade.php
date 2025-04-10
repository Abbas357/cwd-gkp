<x-main-layout>
    @push('style')
    <style>
        .info-group {
            margin-bottom: 1.5rem;
        }
        .info-label {
            font-weight: bold;
            color: #666;
        }
        .info-value {
            color: #333;
        }
    </style>
    @endpush

    @include('site.contractors.partials.header')

    <div class="container p-2">
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold text-uppercase">
                Account
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-group">
                            <div class="info-label">Name</div>
                            <div class="info-value">{{ $contractor->name }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $contractor->email }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Firm / Company Name</div>
                            <div class="info-value">{{ $contractor->firm_name }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-group">
                            <div class="info-label">Mobile No.</div>
                            <div class="info-value">{{ $contractor->mobile_number }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">CNIC No</div>
                            <div class="info-value">{{ $contractor->cnic }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">District</div>
                            <div class="info-value">{{ $contractor->district }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-group">
                            <div class="info-label">Address (as per PEC)</div>
                            <div class="info-value">{{ $contractor->address }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Account Status</div>
                            <div class="info-value">
                                <span class="badge bg-{{ $contractor->status === 'approved' ? 'success' : 'warning' }}">
                                    {{ ucfirst($contractor->status) }} {{ $contractor->status === 'new' ? "(In Progress)" : '' }}
                                </span>
                            </div>
                        </div>
                        @if($contractor->remarks)
                            <div class="info-group">
                                <div class="info-label">Deferral Reason</div>
                                <div class="info-value text-danger">{{ $contractor->remarks }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-4">
                        @if($contractor->hasMedia('contractor_pictures'))
                            <div class="info-group">
                                <div class="info-label">Profile Picture</div>
                                <div class="info-value">
                                    <img src="{{ $contractor->getFirstMediaUrl('contractor_pictures') }}" alt="Contractor Picture" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        @if($contractor->hasMedia('contractor_cnic_front'))
                            <div class="info-group">
                                <div class="info-label">CNIC (Front Side)</div>
                                <div class="info-value">
                                    <img src="{{ $contractor->getFirstMediaUrl('contractor_cnic_front') }}" alt="CNIC Front" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        @if($contractor->hasMedia('contractor_cnic_back'))
                            <div class="info-group">
                                <div class="info-label">CNIC (Back Side)</div>
                                <div class="info-value">
                                    <img src="{{ $contractor->getFirstMediaUrl('contractor_cnic_back') }}" alt="CNIC Back" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <a href="{{ route('contractors.edit') }}" class="btn btn-primary">Edit Information</a>
        </div>
    </div>
</x-main-layout>