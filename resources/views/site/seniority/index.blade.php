<x-main-layout title="All Seniorities">

    <x-slot name="breadcrumbTitle">Seniority List</x-slot>
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Seniority List</li>
    </x-slot>

    <div class="container mt-4">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Designation</th>
                        <th>BPS</th>
                        <th>Seniority Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($seniorities as $seniority)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $seniority->title }}</td>
                            <td>{{ $seniority->designation }}</td>
                            <td>{{ $seniority->bps }}</td>
                            <td>{{ \Carbon\Carbon::parse($seniority->seniority_date)->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('seniority.show', $seniority->slug) }}" class="cw-btn" data-icon="bi-eye">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $seniorities->links() }} <!-- Paginate links -->
        </div>
    </div>

</x-main-layout>
