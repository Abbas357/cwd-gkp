<x-main-layout title="{{ $eventData['title'] }}">
    @push('style')
        <link rel="stylesheet" href="{{ asset('admin/plugins/lightbox/lightbox.min.css') }}" />
    @endpush

    <x-slot name="breadcrumbTitle">
        {{ $eventData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
        <li class="breadcrumb-item active">{{ $eventData['title'] }}</li>
    </x-slot>
    
    <div class="container mt-3">
        <!-- Publisher Info -->
        <div class="d-flex justify-content-between">
            <p><strong>Published By:</strong> {{ $eventData['published_by'] }}</p>
            <p><strong>Published At:</strong> {{ $eventData['published_at'] }}</p>
        </div>

        <!-- Event Details Table -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Start Date</th>
                        <td>{{ \Carbon\Carbon::parse($eventData['start_datetime'])->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td>{{ \Carbon\Carbon::parse($eventData['end_datetime'])->format('M d, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Start Time</th>
                        <td>{{ \Carbon\Carbon::parse($eventData['start_datetime'])->format('h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>End Time</th>
                        <td>{{ \Carbon\Carbon::parse($eventData['end_datetime'])->format('h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td>{{ $eventData['location'] }}</td>
                    </tr>
                    <tr>
                        <th>Organizer</th>
                        <td>{{ $eventData['organizer'] }}</td>
                    </tr>
                    <tr>
                        <th>Chairperson</th>
                        <td>{{ $eventData['chairperson'] }}</td>
                    </tr>
                    <tr>
                        <th>Participants Type</th>
                        <td>{{ $eventData['participants_type'] }}</td>
                    </tr>
                    <tr>
                        <th>Number of Participants</th>
                        <td>{{ $eventData['no_of_participants'] }}</td>
                    </tr>
                    <tr>
                        <th>Event Type</th>
                        <td>{{ $eventData['event_type'] }}</td>
                    </tr>
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
        <div class="description mt-4">
            <h2>Description</h2>
            <p>{!! nl2br($eventData['description']) !!}</p>
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
