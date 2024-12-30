<x-main-layout title="Notifications">
    @push('style')
    <style>
        table,
        td,
        th {
            vertical-align: middle
        }
    </style>
    @endpush
    <x-slot name="breadcrumbTitle">
        Notifications
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Notifications</li>
    </x-slot>

    <div class="container my-4">

        <!-- Filters Section -->
        <form method="GET" action="{{ route('notifications.index') }}" class="mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <button type="button" class="btn p-0 w-100 text-start" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true" aria-controls="filterCollapse">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h5 class="mb-0" style="text-decoration: none !important">Filter Notifications</h5>
                            <i class="bi bi-arrow-down-circle fs-4" id="accordion-icon"></i>
                        </div>
                    </button>
                </div>
                <div id="filterCollapse" class="collapse show">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" name="search" id="search" class="form-control" placeholder="Enter Notification name or any keywords" value="{{ request('search') }}">
                            </div>

                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label for="date_start" class="form-label">Start Date</label>
                                <input type="date" name="date_start" id="date_start" class="form-control" value="{{ request('date_start') }}">
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label for="date_end" class="form-label">End Date</label>
                                <input type="date" name="date_end" id="date_end" class="form-control" value="{{ request('date_end') }}">
                            </div>

                            <input type="hidden" name="status" value="{{ request('status') }}">

                            <!-- District Filter -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label for="type" class="form-label">Type</label>
                                <select name="type" id="type" class="form-select">
                                    <option value="">Type</option>
                                    @foreach ($types as $type)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="col-lg-12 text-end">
                                <button type="submit" class="cw-btn cw-simple" data-icon="bi-funnel">
                                    Apply Filters
                                </button>
                                <a href="{{ route('notifications.index') }}" class="btn btn-light">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Type of Notification</th>
                    <th>View / Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $notification)
                <tr>
                    <td>{{ ($notifications->currentPage() - 1) * $notifications->perPage() + $loop->iteration }}</td>
                    <td>{{ $notification->title ?? '' }}</td>
                    <td>
                        @php
                            $type = class_basename($notification->notifiable_type);
                        @endphp
                        {{ $type ?? '' }}
                    </td>
                    <td>
                        <a href="{{ $notification->url }}" class="cw-btn fs-6" style="white-space: nowrap">
                            <i class="bi-eye"></i> View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="d-flex justify-content-around mt-4">
            {{ $notifications->links() }}
        </div>
    </div>

    @push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterCollapse = document.getElementById('filterCollapse');
            const icon = document.getElementById('accordion-icon');

            filterCollapse.addEventListener('shown.bs.collapse', function() {
                icon.classList.remove('bi-arrow-down-circle');
                icon.classList.add('bi-arrow-up-circle');
            });

            filterCollapse.addEventListener('hidden.bs.collapse', function() {
                icon.classList.remove('bi-arrow-up-circle');
                icon.classList.add('bi-arrow-down-circle');
            });
        });

    </script>
    @endpush
</x-main-layout>
