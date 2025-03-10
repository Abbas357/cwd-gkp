<x-hr-layout>
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.hr.sanctioned-posts.index') }}">Sanctioned Posts</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $data['sanctionedPost']->office->name }} - {{ $data['sanctionedPost']->designation->name }}</li>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Sanctioned Post Details</h5>
            <div class="card-tools">
                <a href="{{ route('admin.apps.hr.sanctioned-posts.edit', $data['sanctionedPost']->id) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Office:</th>
                            <td>{{ $data['sanctionedPost']->office->name }}</td>
                        </tr>
                        <tr>
                            <th>Designation:</th>
                            <td>{{ $data['sanctionedPost']->designation->name }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span class="badge bg-{{ $data['sanctionedPost']->status === 'Active' ? 'success' : 'danger' }}">
                                    {{ $data['sanctionedPost']->status }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center p-2">
                                    <h3 class="mb-0">{{ $data['sanctionedPost']->total_positions }}</h3>
                                    <p class="mb-0 small">Total Positions</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center p-2">
                                    <h3 class="mb-0">{{ $data['filledPositions'] }}</h3>
                                    <p class="mb-0 small">Filled</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card {{ $data['vacancies'] > 0 ? 'bg-success' : 'bg-danger' }} text-white">
                                <div class="card-body text-center p-2">
                                    <h3 class="mb-0">{{ $data['vacancies'] }}</h3>
                                    <p class="mb-0 small">Vacant</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h6 class="mb-3">Current Postings ({{ count($data['currentPostings']) }})</h6>
                    @if(count($data['currentPostings']) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Posting Type</th>
                                        <th>Start Date</th>
                                        <th>Order Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['currentPostings'] as $posting)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ getProfilePic($posting->user) }}" alt="Profile" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                                    {{ $posting->user->name }}
                                                </div>
                                            </td>
                                            <td>{{ $posting->type }}</td>
                                            <td>{{ $posting->start_date->format('d M, Y') }}</td>
                                            <td>{{ $posting->order_number ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('admin.apps.hr.users.edit', $posting->user_id) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil-square"></i> Edit User
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No users are currently posted to this position.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script>
        $(document).ready(function() {
            // Any additional JavaScript for this page
        });
    </script>
    @endpush
</x-hr-layout>