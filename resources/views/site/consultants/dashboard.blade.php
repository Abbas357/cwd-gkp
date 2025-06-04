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

    @include('site.consultants.partials.header')

    <div class="container p-2">
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold text-uppercase">
                Account <span class="ms-3 step-indicator">Step 1 of 3</span> <span class="ms-3 subtitle">First step is complete. Click <a href="{{ route('consultants.hr.create') }}">here</a> to proceed and enter HR details.</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-group">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $consultant->email }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">PEC Number</div>
                            <div class="info-value">{{ $consultant->pec_number }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Firm / Company Name</div>
                            <div class="info-value">{{ $consultant->name }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-group">
                            <div class="info-label">Contact Number.</div>
                            <div class="info-value">{{ $consultant->contact_number }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">District</div>
                            <div class="info-value">{{ $consultant->district?->name }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Sector</div>
                            <div class="info-value">{{ $consultant->sector }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-group">
                            <div class="info-label">Address (as per PEC)</div>
                            <div class="info-value">{{ $consultant->address }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Status / Tracking</div>
                            <div class="info-value">
                                @php
                                    $status = $consultant->status;
                                    $statusClass = match ($status) {
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        default => 'secondary',
                                    };
                                    $statusLabel = ucfirst($status);
                                @endphp

                                <span class="badge fs-6 px-3 py-2 my-2 bg-{{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <a href="{{ route('consultants.edit') }}" class="btn btn-primary">Edit Information</a>
        </div>
    </div>
</x-main-layout>