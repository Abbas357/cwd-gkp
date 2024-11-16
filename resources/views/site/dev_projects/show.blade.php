<x-main-layout title="Development Project Details">

    @push('style')
        <link rel="stylesheet" href="{{ asset('admin/plugins/lightbox/lightbox.min.css') }}" />
    @endpush

    <x-slot name="breadcrumbTitle">
        {{ $projectData['name'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('development_projects.index') }}">Development Projects</a></li>
        <li class="breadcrumb-item active">{{ $projectData['name'] }}</li>
    </x-slot>

    <div class="container mt-3">

        <!-- Project Info -->
        <div class="d-flex justify-content-between">
            <p><strong>Chief Engineer:</strong> {{ $projectData['chief_engineer'] }}</p>
            <p><strong>Superintendent Engineer:</strong> {{ $projectData['superintendent_engineer'] }}</p>
        </div>

        <!-- Project Details Table -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $projectData['name'] }}</td>
                    </tr>
                    <tr>
                        <th>Introduction</th>
                        <td>{!! nl2br($projectData['introduction']) !!}</td>
                    </tr>
                    <tr>
                        <th>Total Cost</th>
                        <td>${{ number_format($projectData['total_cost'], 2) ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Commencement Date</th>
                        <td>{{ \Carbon\Carbon::parse($projectData['commencement_date'])->format('M d, Y') ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>District</th>
                        <td>{{ $projectData['district'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Work Location</th>
                        <td>{{ $projectData['work_location'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Progress Percentage</th>
                        <td>{{ $projectData['progress_percentage'] ?? 'N/A' }}%</td>
                    </tr>
                    <tr>
                        <th>Year of Completion</th>
                        <td>{{ $projectData['year_of_completion'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $projectData['status'] ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Project Images with Lightbox -->
        <div class="images mt-4">
            <h5>Attached Images</h5>
            <div class="row">
                @foreach($projectData['images'] as $image)
                    <div class="col-md-3 mb-3">
                        <a href="{{ $image }}" data-lightbox="project-images" data-title="{{ $projectData['name'] }}">
                            <img src="{{ $image }}" class="img-fluid rounded mb-3" alt="{{ $projectData['name'] }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    @push('script')
        <script src="{{ asset('admin/plugins/lightbox/lightbox.min.js') }}"></script>
        <script>
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'disableScrolling': true,
            });
        </script>
    @endpush

</x-main-layout>
