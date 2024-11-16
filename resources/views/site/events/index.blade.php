<x-main-layout title="Events">
    
    <x-slot name="breadcrumbTitle">
        Events
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Events</li>
    </x-slot>

    <div class="container my-4">
    
        <!-- Event List -->
        <div class="list-group">
            @foreach ($newsItems as $event)
                <div class="list-group-item py-4">
                    <div class="row">
                        <!-- Conditional Image -->
                        <div class="col-md-2">
                            @if ($event->getFirstMedia('events_pictures') && $event->getFirstMedia('events_pictures')->mime_type === 'image/jpeg')
                                <img src="{{ $event->getFirstMediaUrl('events_pictures') }}" 
                                     alt="{{ $event->title }}"
                                     class="img-fluid rounded" 
                                     style="max-height: 100px; width: auto;">
                            @else
                                <img src="{{ asset('admin/images/no-image.jpg') }}" 
                                     alt="No image available" 
                                     class="img-fluid rounded" 
                                     style="max-height: 100px; width: auto;">
                            @endif
                        </div>
    
                        <!-- Title, Date, Event Details, and Read More on the right -->
                        <div class="col-md-10">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('events.show', $event->slug) }}"><h5 class="mt-0">{{ $event->title }}</h5></a>
                                <small class="text-muted">{{ $event->published_at->format('M d, Y') }}</small>
                            </div>
                            <p class="mb-1">
                                <span>Organizer: {{ $event->organizer ?? 'N/A'  }}</span> - <span>Chairperson: {{ $event->chairperson ?? 'N/A' }}</span>
                            </p>
                            <div>
                                <strong>Date:</strong> {{ $event->start_datetime->format('M d, Y') ?? 'N/A' }} to  {{ $event->end_datetime->format('M d, Y') ?? 'N/A' }}<br>
                                <strong>Time:</strong> {{ $event->start_datetime->format('h:i A') ?? 'N/A' }} to {{ $event->end_datetime->format('h:i A') ?? 'N/A' }}<br>
                            </div>

                            <a href="{{ route('events.show', $event->slug) }}" class="btn btn-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    
        <!-- Pagination links -->
        <div class="d-flex justify-content-center mt-4">
            {{ $newsItems->links() }}
        </div>
    </div>
</x-main-layout>
