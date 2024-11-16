<x-main-layout title="Development Projects">

    <x-slot name="breadcrumbTitle">
        Development Projects
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Development Projects</li>
    </x-slot>

    <div class="container my-4">

        <!-- Table for displaying development projects -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Introduction</th>
                    <th>Total Cost</th>
                    <th>Commencement Date</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $project->name }}</td>
                        <td>{!! Str::limit($project->introduction, 50) !!}</td>
                        <td>${{ number_format($project->total_cost, 2) ?? 'N/A' }}</td>
                        <td>{{ $project->commencement_date->format('M d, Y') ?? 'N/A' }}</td>
                        <td>{{ $project->progress_percentage ?? '50%' }}%</td>
                        <td>{{ $project->status }}</td>
                        <td>
                            <a href="{{ route('development_projects.show', $project->slug) }}" class="btn btn-primary btn-sm">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="d-flex justify-content-center mt-4">
            {{ $projects->links() }}
        </div>
    </div>

</x-main-layout>
