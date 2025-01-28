<x-main-layout title="Development Project Details">

    @push('style')
        <link rel="stylesheet" href="{{ asset('site/lib/lightbox/lightbox.min.css') }}" />
        <style>
            table, td, th {
                vertical-align: middle
            }
        </style>
    @endpush

    <x-slot name="breadcrumbTitle">
        {{ $projectData['name'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('development_projects.index') }}">Development Projects</a></li>
    </x-slot>

    <div class="container mt-3">

        <div class="d-flex justify-content-between">
            <p><strong>Chief Engineer:</strong> {{ $projectData['chief_engineer'] }}</p>
            <p><strong>Views: </strong> {{ $projectData['views_count'] }}</p>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <tbody>
                    @if(!empty($projectData['name']))
                        <tr>
                            <th>Name</th>
                            <td>{{ $projectData['name'] }}</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['introduction']))
                        <tr>
                            <th>Introduction</th>
                            <td>{!! nl2br($projectData['introduction']) !!}</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['total_cost']))
                        <tr>
                            <th>Total Cost</th>
                            <td>&#8360; {{ number_format($projectData['total_cost'], 2) }} (Millions)</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['commencement_date']))
                        <tr>
                            <th>Commencement Date</th>
                            <td>{{ \Carbon\Carbon::parse($projectData['commencement_date'])->format('M d, Y') }}</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['district']))
                        <tr>
                            <th>District</th>
                            <td>{{ $projectData['district'] }}</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['work_location']))
                        <tr>
                            <th>Work Location</th>
                            <td>{{ $projectData['work_location'] }}</td>
                        </tr>
                    @endif
                    @if(isset($projectData['progress_percentage']))
                        <tr>
                            <th>Progress Percentage</th>
                            <td>{{ $projectData['progress_percentage'] }}%</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['year_of_completion']))
                        <tr>
                            <th>Year of Completion</th>
                            <td>{{ $projectData['year_of_completion'] }}</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['status']))
                        <tr>
                            <th>Status</th>
                            <td>{{ $projectData['status'] }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

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

    <x-sharer :title="$projectData['name'].' - '.config('app.name')" :url="url()->current()" />

    @if(in_array('DevelopmentProject', json_decode(App\Models\Setting::first()->commentable_tables ?? '[]', true)))
        <x-comments :comments="$projectData['comments']" modelType="DevelopmentProject" :modelId="$projectData['id']" />
    @endif
    

    @push('script')
        <script src="{{ asset('site/lib/lightbox/lightbox.min.js') }}"></script>
        <script>
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'disableScrolling': true,
            });
        </script>
    @endpush

</x-main-layout>
