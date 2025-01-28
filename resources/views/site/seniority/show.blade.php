<x-main-layout title="{{ $seniorityData['title'] }}">

    @push('style')
    <link rel="stylesheet" href="{{ asset('site/lib/lightbox/lightbox.min.css') }}" />
    @endpush

    <x-slot name="breadcrumbTitle">{{ $seniorityData['title'] }}</x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('seniority.index') }}">Seniority List</a></li>
    </x-slot>

    <div class="container mt-4">
        <p style="text-align: right"><strong>Views:</strong> {{ $seniorityData['views_count'] }}</p>
        <!-- Seniority Details Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Title</th>
                        <td>{{ $seniorityData['title'] }}</td>
                    </tr>
                    <tr>
                        <th>Designation</th>
                        <td>{{ $seniorityData['designation'] }}</td>
                    </tr>
                    <tr>
                        <th>BPS</th>
                        <td>{{ $seniorityData['bps'] }}</td>
                    </tr>
                    <tr>
                        <th>Seniority Date</th>
                        <td>{{ $seniorityData['seniority_date'] }}</td>
                    </tr>
                    @if ($seniorityData['attachment'])
                    <tr>
                        <th>Attachement</th>
                        <td>
                            <a href="{{ $seniorityData['attachment'] }}">
                                Download
                            </a>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Attachment (Media) Section with Lightbox -->
        
    </div>

    <x-sharer :title="$seniorityData['title'].' - '.config('app.name')" :url="url()->current()" />

    @if(in_array('Seniority', json_decode(App\Models\Setting::first()->commentable_tables ?? '[]', true)))
        <x-comments :comments="$seniorityData['comments']" modelType="Seniority" :modelId="$seniorityData['id']" />
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