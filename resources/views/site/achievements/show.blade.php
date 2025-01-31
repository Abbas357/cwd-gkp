<x-main-layout title="{{ $achievementData['title'] }}">
    @push('style')
    <link rel="stylesheet" href="{{ asset('site/lib/lightbox/lightbox.min.css') }}" />
    @endpush

    <x-slot name="breadcrumbTitle">
        {{ $achievementData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('Achievements.index') }}">Achievements</a></li>
    </x-slot>

    <div class="container mt-3">
        <!-- Publisher Info -->
        <div class="d-flex justify-content-between">
            <p><strong>Published At:</strong> {{ $achievementData['published_at'] }}</p>
            <p><strong>Views:</strong> {{ $achievementData['views_count'] }}</p>
        </div>
        <!-- Achievement Details Table -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <tbody>
                    @if(!empty($achievementData['start_datetime']) && !empty($achievementData['end_datetime']))
                    <tr>
                        <th>Date</th>
                        <td>
                            {{ \Carbon\Carbon::parse($achievementData['start_datetime'])->format('M d, Y') }}
                            @if(\Carbon\Carbon::parse($achievementData['start_datetime'])->format('M d, Y') != \Carbon\Carbon::parse($achievementData['end_datetime'])->format('M d, Y'))
                            to {{ \Carbon\Carbon::parse($achievementData['end_datetime'])->format('M d, Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td>
                            {{ \Carbon\Carbon::parse($achievementData['start_datetime'])->format('h:i A') }}
                            to {{ \Carbon\Carbon::parse($achievementData['end_datetime'])->format('h:i A') }}
                        </td>
                    </tr>
                    @elseif(!empty($achievementData['start_datetime']))
                    <tr>
                        <th>Date</th>
                        <td>{{ \Carbon\Carbon::parse($achievementData['start_datetime'])->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td>{{ \Carbon\Carbon::parse($achievementData['start_datetime'])->format('h:i A') }}</td>
                    </tr>
                    @endif

                    @if(!empty($achievementData['location']))
                    <tr>
                        <th>Location</th>
                        <td>{{ $achievementData['location'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($achievementData['organizer']))
                    <tr>
                        <th>Organizer</th>
                        <td>{{ $achievementData['organizer'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($achievementData['chairperson']))
                    <tr>
                        <th>Chairperson</th>
                        <td>{{ $achievementData['chairperson'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($achievementData['participants_type']))
                    <tr>
                        <th>Participants Type</th>
                        <td>{{ $achievementData['participants_type'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($achievementData['no_of_participants']))
                    <tr>
                        <th>Number of Participants</th>
                        <td>{{ $achievementData['no_of_participants'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($achievementData['achievement_type']))
                    <tr>
                        <th>Achievement Type</th>
                        <td>{{ $achievementData['achievement_type'] }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Achievement Images with Lightbox -->
        <div class="images mt-4">
            <h2>Achievement Images</h2>
            <div class="row">
                @foreach($achievementData['images'] as $image)
                <div class="col-md-4 mb-3">
                    <a href="{{ $image }}" data-lightbox="Achievement-images" data-title="{{ $achievementData['title'] }}">
                        <img src="{{ $image }}" class="img-fluid rounded mb-3" alt="{{ $achievementData['title'] }}">
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Description Section -->
        @if(!empty($achievementData['description']))
        <div class="description mt-4">
            <h2>Description</h2>
            <p>{!! nl2br($achievementData['description']) !!}</p>
        </div>
        @endif
    </div>

    <x-sharer :title="$achievementData['title'].' - '.config('app.name')" :url="url()->current()" />

    @if(in_array('Achievement', json_decode(App\Models\Setting::first()->commentable_tables ?? '[]', true)))
        <x-comments :comments="$achievementData['comments']" modelType="Achievement" :modelId="$achievementData['id']" />
    @endif

    @push('script')
    <script src="{{ asset('site/lib/lightbox/lightbox.min.js') }}"></script>
    <script>
        lightbox.option({
            'resizeDuration': 200
            , 'wrapAround': true
            , 'disableScrolling': true
        , });
    </script>
    @endpush
</x-main-layout>
