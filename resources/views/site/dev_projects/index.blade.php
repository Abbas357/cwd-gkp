<x-main-layout title="Development Projects">
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
        Development Projects
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Development Projects</li>
    </x-slot>

    <div class="container my-4">

        <!-- Filters Section -->
        <form method="GET" action="{{ route('development_projects.index') }}" class="mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <button type="button" class="btn p-0 w-100 text-start" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="{{ request('search') || request('date_start') || request('date_end') || request('district_id') ? 'true' : 'false' }}" aria-controls="filterCollapse">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h5 class="mb-0" style="text-decoration: none !important">Filter Projects</h5>
                            <i class="bi bi-arrow-down-circle fs-4" id="accordion-icon"></i>
                        </div>
                    </button>
                </div>
                <div id="filterCollapse" class="collapse {{ request('search') || request('date_start') || request('date_end') || request('district_id') ? 'show' : '' }}">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" name="search" id="search" class="form-control" placeholder="Enter project name or keywords" value="{{ request('search') }}">
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
                                <label for="district_id" class="form-label">District</label>
                                <select name="district_id" id="district_id" class="form-select">
                                    <option value="">All Districts</option>
                                    @foreach (\App\Models\District::all() as $district)
                                    <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="col-lg-12 text-end">
                                <button type="submit" class="cw-btn cw-simple" data-icon="bi-funnel">
                                    Apply Filters
                                </button>
                                <a href="{{ route('development_projects.index') }}" class="btn btn-light" data-icon="bi-arrow-repeat">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Projects Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>District</th>
                    <th>Total Cost</th>
                    <th>Commencement Date</th>
                    <th>Progress</th>
                    <th>Views</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                <tr>
                    <td>{{ ($projects->currentPage() - 1) * $projects->perPage() + $loop->iteration }}</td>
                    <td>{{ $project->name ?? '' }}</td>
                    <td>{{ $project->district->name ?? '' }}</td>
                    <td>{{ $project->total_cost ? number_format($project->total_cost, 2) : '' }}</td>
                    <td>{{ $project->commencement_date ? $project->commencement_date->format('M d, Y') : '' }}</td>
                    <td>{{ isset($project->progress_percentage) ? $project->progress_percentage . '%' : '' }}</td>
                    <td>{{ $project->views_count }}</td>
                    <td>
                        <a href="{{ route('development_projects.show', $project->slug) }}" class="cw-btn" style="white-space: nowrap"><i class="bi-eye"></i> View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="d-flex justify-content-around mt-4">
            {{ $projects->links() }}
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
