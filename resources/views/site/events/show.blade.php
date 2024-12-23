<x-main-layout title="{{ $eventData['title'] }}">
    @push('style')
    <link rel="stylesheet" href="{{ asset('admin/plugins/lightbox/lightbox.min.css') }}" />
    @endpush

    <x-slot name="breadcrumbTitle">
        {{ $eventData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
    </x-slot>

    <div class="container mt-3">
        <!-- Publisher Info -->
        <div class="d-flex justify-content-between">
            <p><strong>Published At:</strong> {{ $eventData['published_at'] }}</p>
            <p><strong>Views:</strong> {{ $eventData['views_count'] }}</p>
        </div>
        <!-- Event Details Table -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <tbody>
                    @if(!empty($eventData['start_datetime']) && !empty($eventData['end_datetime']))
                    <tr>
                        <th>Date</th>
                        <td>
                            {{ \Carbon\Carbon::parse($eventData['start_datetime'])->format('M d, Y') }}
                            @if(\Carbon\Carbon::parse($eventData['start_datetime'])->format('M d, Y') != \Carbon\Carbon::parse($eventData['end_datetime'])->format('M d, Y'))
                            to {{ \Carbon\Carbon::parse($eventData['end_datetime'])->format('M d, Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td>
                            {{ \Carbon\Carbon::parse($eventData['start_datetime'])->format('h:i A') }}
                            to {{ \Carbon\Carbon::parse($eventData['end_datetime'])->format('h:i A') }}
                        </td>
                    </tr>
                    @elseif(!empty($eventData['start_datetime']))
                    <tr>
                        <th>Date</th>
                        <td>{{ \Carbon\Carbon::parse($eventData['start_datetime'])->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td>{{ \Carbon\Carbon::parse($eventData['start_datetime'])->format('h:i A') }}</td>
                    </tr>
                    @endif

                    @if(!empty($eventData['location']))
                    <tr>
                        <th>Location</th>
                        <td>{{ $eventData['location'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($eventData['organizer']))
                    <tr>
                        <th>Organizer</th>
                        <td>{{ $eventData['organizer'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($eventData['chairperson']))
                    <tr>
                        <th>Chairperson</th>
                        <td>{{ $eventData['chairperson'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($eventData['participants_type']))
                    <tr>
                        <th>Participants Type</th>
                        <td>{{ $eventData['participants_type'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($eventData['no_of_participants']))
                    <tr>
                        <th>Number of Participants</th>
                        <td>{{ $eventData['no_of_participants'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($eventData['event_type']))
                    <tr>
                        <th>Event Type</th>
                        <td>{{ $eventData['event_type'] }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Event Images with Lightbox -->
        <div class="images mt-4">
            <h2>Event Images</h2>
            <div class="row">
                @foreach($eventData['images'] as $image)
                <div class="col-md-4 mb-3">
                    <a href="{{ $image }}" data-lightbox="event-images" data-title="{{ $eventData['title'] }}">
                        <img src="{{ $image }}" class="img-fluid rounded mb-3" alt="{{ $eventData['title'] }}">
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Description Section -->
        @if(!empty($eventData['description']))
        <div class="description mt-4">
            <h2>Description</h2>
            <p>{!! nl2br($eventData['description']) !!}</p>
        </div>
        @endif
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/lightbox/lightbox.min.js') }}"></script>
    <script>
        lightbox.option({
            'resizeDuration': 200
            , 'wrapAround': true
            , 'disableScrolling': true
        , });

    </script>
    @endpush
</x-main-layout>
