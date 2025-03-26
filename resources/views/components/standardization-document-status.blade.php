<div class="card mb-4">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <span class="fw-bold text-uppercase">Document Upload Status</span>
        <span class="badge bg-{{ $getStatusClass() }}">
            {{ $uploadedCount }} / {{ $totalCount }} Documents
        </span>
    </div>
    <div class="card-body">
        <div class="progress mb-3">
            <div class="progress-bar bg-{{ $getStatusClass() }}" 
                 role="progressbar" 
                 style="width: {{ $percentComplete }}%" 
                 aria-valuenow="{{ $percentComplete }}" 
                 aria-valuemin="0" 
                 aria-valuemax="100">
                {{ round($percentComplete) }}%
            </div>
        </div>
        
        <div class="row">
            @foreach ($requiredDocuments as $key => $name)
                <div class="col-md-6 mb-2">
                    <div class="d-flex align-items-center">
                        @if ($standardization->hasMedia($key))
                            <i class="bi-check-circle-fill text-success me-2"></i>
                        @else
                            <i class="bi-x-circle-fill text-danger me-2"></i>
                        @endif
                        <span>{{ $name }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if (!$isComplete())
            <div class="alert alert-warning mt-3">
                <i class="bi-exclamation-triangle-fill me-2"></i>
                You must upload all required documents before you can access product management features.
            </div>
        @else
            <div class="alert alert-success mt-3">
                <i class="bi-check-circle-fill me-2"></i>
                All required documents have been uploaded. You can now access product management features.
            </div>
        @endif
    </div>
</div>