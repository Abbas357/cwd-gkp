<x-main-layout title="Schemes">
    @push('style')
    <style>
        table,
        td,
        th {
            vertical-align: middle;
        }
    </style>
    @endpush

    <x-slot name="breadcrumbTitle">Schemes</x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Schemes</li>
    </x-slot>

    <div class="container my-4">

        <!-- Filters Section -->
        <form method="GET" action="{{ route('schemes.index') }}" class="mb-4">
            <div class="card shadow-sm mb-4" style="border-radius:0px">
                <div class="card-header d-flex justify-content-between align-items-center p-2">
                    <button type="button" class="btn p-0 w-100 text-start" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="{{ request('search') || request('scheme_code') || request('year') ? 'true' : 'false' }}" aria-controls="filterCollapse">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h5 class="mb-0" style="text-decoration: none !important">Filter Schemes</h5>
                            <i class="bi bi-arrow-down-circle fs-4" id="accordion-icon"></i>
                        </div>
                    </button>
                </div>
                <div id="filterCollapse" class="collapse show">
                    <div class="card-body p-2">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" name="search" id="search" class="form-control" placeholder="Enter scheme name or keywords" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <label for="year" class="form-label">Year</label>
                                <select name="year" id="year" class="form-select">
                                    <option value="">Select Year</option>
                                    @foreach (getYears() as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <label for="sector_name" class="form-label">Sector</label>
                                <select name="sector_name" id="sector_name" class="form-select">
                                    <option value="">Select Sector</option>
                                    @foreach ($sectors as $sector)
                                        <option value="{{ $sector }}" 
                                            {{ request('sector_name', 'road') == $sector ? 'selected' : '' }}>
                                            {{ ucfirst($sector) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <label for="adp_number" class="form-label">ADP Number</label>
                                <input type="text" name="adp_number" id="adp_number" class="form-control" value="{{ request('adp_number') }}">
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <label for="scheme_code" class="form-label">Scheme Code</label>
                                <input type="text" name="scheme_code" id="scheme_code" class="form-control" value="{{ request('scheme_code') }}">
                            </div>
                            <div class="col-lg-12 text-end">
                                <button type="submit" class="cw-btn cw-simple">
                                    <i class="bi bi-funnel"></i> Apply Filters
                                </button>
                                <a href="{{ route('schemes.index') }}" class="btn btn-light">
                                    <i class="bi bi-arrow-repeat"></i> Reset
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
                    <th scope="col" class="p-1">ID</th>
                    <th scope="col" class="p-1">ADP Number</th>
                    <th scope="col" class="p-1">Scheme Code</th>
                    <th scope="col" class="p-1">Year</th>
                    <th scope="col" class="p-1">Scheme Name</th>
                    <th scope="col" class="p-1">Sector Name</th>
                    <th scope="col" class="p-1">Local Cost</th>
                    <th scope="col" class="p-1">Previous Expenditure</th>
                    <th scope="col" class="p-1">Revenue Allocation</th>
                    <th scope="col" class="p-1">Total Allocation</th>
                    <th scope="col" class="p-1">Views</th>
                    <th scope="col" class="p-1">Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schemes as $scheme)
                <tr>
                    <td>{{ ($schemes->currentPage() - 1) * $schemes->perPage() + $loop->iteration }}</td>
                    <td>{{ $scheme->adp_number ?? '' }}</td>
                    <td>{{ $scheme->scheme_code ?? '' }}</td>
                    <td>{{ $scheme->year ?? '' }}</td>
                    <td>{{ $scheme->scheme_name ?? '' }}</td>
                    <td>{{ $scheme->sector_name ?? '' }}</td>
                    <td>{{ $scheme->local_cost ?? '' }}</td>
                    <td>{{ $scheme->previous_expenditure ?? '' }}</td>
                    <td>{{ $scheme->revenue_allocation ?? '' }}</td>
                    <td>{{ $scheme->total_allocation ?? '' }}</td>
                    <td>{{ $scheme->views_count }}</td>
                    <td>
                        <a href="{{ route('schemes.show', $scheme->uuid) }}" class="cw-btn" style="white-space: nowrap"><i class="bi-eye"></i> View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="d-flex justify-content-around mt-4">
            {{ $schemes->links() }}
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
