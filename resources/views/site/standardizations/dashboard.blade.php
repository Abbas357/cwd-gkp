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

    @include('site.standardizations.partials.header')
    
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
                            <div class="info-value">{{ $standardization->name }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $standardization->email }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Firm / Company Name</div>
                            <div class="info-value">{{ $standardization->firm_name }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-group">
                            <div class="info-label">Mobile No.</div>
                            <div class="info-value">{{ $standardization->mobile_number }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">CNIC No</div>
                            <div class="info-value">{{ $standardization->cnic }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">District</div>
                            <div class="info-value">{{ $standardization->district }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-group">
                            <div class="info-label">Address (as per PEC)</div>
                            <div class="info-value">{{ $standardization->address }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Status / Tracking</div>
                            <div class="info-value">
                                @php
                                    $status = $standardization->status;
                                    $statusClass = match ($status) {
                                        'Approved' => 'success',
                                        'Pending' => 'warning',
                                        'Approval Committee' => 'info',
                                        'Rejected' => 'danger',
                                        default => 'secondary',
                                    };
                                    $statusLabel = ucfirst($status);
                                @endphp

                                <span class="badge fs-6 px-3 py-2 my-2 bg-{{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>
                        @if($standardization->remarks && $status === 'Rejected')
                            <div class="info-group">
                                <div class="info-label">Remarks</div>
                                <div class="info-value text-danger">{{ $standardization->remarks }}</div>
                            </div>
                        @elseif ($standardization->remarks && $status === 'Approved')
                            <div class="info-group">
                                <div class="info-label">Remarks</div>
                                <div class="info-value text-success">Your firm has been approved. Please collect your card from the IT Section, C&W Department.</div>
                            </div>
                        @elseif ($standardization->remarks && $status === 'Approval Committee')
                            <div class="info-group">
                                <div class="info-label">Remarks</div>
                                <div class="info-value text-warning">Submitted to the Approval Committee for review. Good luck!</div>
                            </div>
                        @else
                            <div class="info-group">
                                <div class="info-label">Remarks</div>
                                <div class="info-value text-secondary">Please wait, your firm will be submitted to the approval committee shortly, Keep in touch.</div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-4">
                        @if($standardization->hasMedia('standardization_firms_pictures'))
                            <div class="info-group">
                                <div class="info-label">Firm Picture</div>
                                <div class="info-value">
                                    <img src="{{ $standardization->getFirstMediaUrl('standardization_firms_pictures') }}" alt="Firm Picture" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <x-standardization-document-status :standardization="$standardization" />
        <div class="d-flex justify-content-end">
            <a href="{{ route('standardizations.edit') }}" class="btn btn-primary">Edit Information</a>
        </div>
    </div>
</x-main-layout>