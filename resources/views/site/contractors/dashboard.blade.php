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

        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <div class="row"> 
            @if($profile_status['empty_fields'] > 0)
                <div class="alert alert-danger mb-4">
                    <strong>Profile Incomplete:</strong> {{ $profile_status['empty_fields'] }} out of {{ $profile_status['total_fields'] }} fields need to be filled.
                </div>
            @endif
            <div class="col-md-6">
                <div class="info-group">
                    <div class="info-label">Owner Name</div>
                    <div class="info-value">{{ $contractor->owner_name }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Contractor Name</div>
                    <div class="info-value">{{ $contractor->contractor_name }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">PEC Number</div>
                    <div class="info-value">{{ $contractor->pec_number }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Category Applied</div>
                    <div class="info-value">{{ $contractor->category_applied }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-group">
                    <div class="info-label">District</div>
                    <div class="info-value">{{ $contractor->district }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">CNIC</div>
                    <div class="info-value">{{ $contractor->cnic }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $contractor->email }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Mobile Number</div>
                    <div class="info-value">{{ $contractor->mobile_number }}</div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="info-group">
                <div class="info-label">Address</div>
                <div class="info-value">{{ $contractor->address }}</div>
            </div>
            <div class="info-group">
                <div class="info-label">Registration Status</div>
                <div class="info-value">
                    <span class="badge bg-{{ $contractor->status === 'approved' ? 'success' : 'warning' }}">
                        {{ ucfirst($contractor->status) }} ({{ $contractor->status === 'new' ? "In Progress" : ''  }})
                    </span>
                </div>
            </div>
            @if($contractor->deffered_reason)
            <div class="info-group">
                <div class="info-label">Deferral Reason</div>
                <div class="info-value text-danger">{{ $contractor->deffered_reason }}</div>
            </div>
            @endif
        </div>
    </div>
</x-main-layout>