<x-main-layout>
    @push('style')
    <style>
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status-draft { background: #3094f8; color: #fff; }
        .status-deferred_once { background: #fa8611; color: #fff; }
        .status-deferred_twice { background: #fa511d; color: #fff; }
        .status-deferred_thrice { background: #d31b1b; color: #fff; }
        .status-approved { background: #11af19; color: #fff; }
        
        .custom-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .custom-dropdown-menu {
            position: absolute;
            z-index: 9999;
            display: none;
            min-width: 160px;
            padding: 0.5rem 0;
            background-color: #fff;
            border: 1px solid rgba(0,0,0,.15);
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175);
            right: 0;
        }
        
        .custom-dropdown-menu.show {
            display: block;
        }
        
        .custom-dropdown-item {
            display: block;
            width: 100%;
            padding: 0.5rem 1rem;
            clear: both;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
            color: #212529;
            text-decoration: none;
        }
        
        .custom-dropdown-item:hover {
            background-color: #f8f9fa;
            color: #16181b;
        }
        
        .document-preview {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .document-preview img {
            max-width: 100%;
            height: auto;
            margin-top: 0.5rem;
        }
        
        .document-title {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
        }
        </style>
    @endpush
    @include('site.contractors.partials.header')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-0">Contractor Registrations</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('contractors.registration.create') }}" class="btn btn-primary">
                            New Registration
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('contractors.registration.index') }}" method="GET" class="mb-4">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" 
                                placeholder="Search by PEC, Name, FBR, or KPRA..."
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>New</option>
                                <option value="deferred_once" {{ request('status') === 'deferred_once' ? 'selected' : '' }}>Deferred Once</option>
                                <option value="deferred_twice" {{ request('status') === 'deferred_twice' ? 'selected' : '' }}>Deferred Twice</option>
                                <option value="deferred_thrice" {{ request('status') === 'deferred_thrice' ? 'selected' : '' }}>Deferred Thrice</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" 
                                        {{ request('category') === $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('contractors.registration.index') }}" class="btn btn-light">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive" style="min-height: 200px">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>PEC Number</th>
                                <th>PEC Category</th>
                                <th>Status</th>
                                <th>Applied Date</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $registration)
                                <tr>
                                    <td>{{ $registration->pec_number }}</td>
                                    <td>{{ $registration->pec_category }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $registration->status }}">
                                            {{ str_replace('_', ' ', ucfirst($registration->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $registration->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @php
                                            $status = $registration->status;
                                            $remarks = $registration->remarks ?? 'No specific remarks provided';
                                            $pecNumber = $registration->pec_number;
                                            $category = $registration->pec_category;
                                    
                                            switch ($status) {
                                                case 'draft':
                                                    $message = 'Your registration is currently under review by the enlistment committee.';
                                                    $bgClass = 'bg-info';
                                                    break;
                                                case 'deferred_once':
                                                    $message = 'Your registration was deferred with feedback: "' . $remarks . '". The application will be reviewed in the next enlistment committee meeting.';
                                                    $bgClass = 'bg-warning';
                                                    break;
                                                case 'deferred_twice':
                                                    $message = 'Your registration has been deferred twice with feedback: "' . $remarks . '". Final decision pending in the next committee meeting.';
                                                    $bgClass = 'bg-warning';
                                                    break;
                                                case 'deferred_thrice':
                                                    $message = "Registration with PEC number {$pecNumber} was deferred three times. Future applications are limited to category {$category} or lower.";
                                                    $bgClass = 'bg-secondary';
                                                    break;
                                                case 'approved':
                                                    $message = 'Congratulations! Your registration has been approved. Please collect your card from the IT Cell, C&W Department.';
                                                    $bgClass = 'bg-success';
                                                    break;
                                                default:
                                                    $message = $remarks;
                                                    $bgClass = 'bg-light';
                                                    break;
                                            }
                                        @endphp
                                        <div class="p-2 rounded {{ $bgClass }} bg-opacity-25" style="max-width: 300px; white-space: normal;">
                                            <small class="text-dark">{{ $message }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="cw-btn" href="{{ route('contractors.registration.show', $registration->uuid) }}">
                                            <i class="bi-eye"></i>
                                        </a>
                                        @if($registration->can_edit)
                                        <a class="cw-btn cw-btn-secondary" href="{{ route('contractors.registration.edit', $registration->uuid) }}">
                                            <i class="bi-pencil"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">No registrations found</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $registrations->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script>

        // Auto-submit form when filters change
        document.querySelectorAll('select[name="status"], select[name="category"]').forEach(select => {
            select.addEventListener('change', () => {
                select.closest('form').submit();
            });
        });

    </script>
    @endpush
</x-main-layout>