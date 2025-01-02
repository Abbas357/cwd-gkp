<x-main-layout title="Events">
    @push('style')
    <style>
        .list-group-item {
            display: block !important;
            margin-block: .7rem;
            box-shadow: 2px 3px 5px #00000011, -2px -3px 5px #00000011;
        }
        .event-image {
            width: 170px;
            height: 110px
        }
    </style>
    @endpush
    <x-slot name="breadcrumbTitle">
        Events
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Events</li>
    </x-slot>

    <div class="container my-4">

        <div class="list-group">
            @foreach ($eventItems as $event)
            <div class="list-group-item py-2">
                <div class="row p-1">
                    <div class="col-md-2">
                        @if ($event->getFirstMedia('events_pictures') && $event->getFirstMedia('events_pictures')->mime_type === 'image/jpeg')
                        <img src="{{ $event->getFirstMediaUrl('events_pictures') }}" alt="{{ $event->title }}" class="img-fluid rounded event-image">
                        @else
                        <img src="{{ asset('admin/images/no-image.jpg') }}" alt="No image available" class="img-fluid rounded" style="max-height: 100px; width: auto;">
                        @endif
                    </div>

                    <div class="col-md-10">
                        <div class="d-flex justify-content-between">
                            <!-- Left Section -->
                            <div>
                                <a href="{{ route('events.show', $event->slug) }}">
                                    <h5 class="mt-0">{{ $event->title }}</h5>
                                </a>
                                @if(!empty($event->start_datetime) && !empty($event->end_datetime))
                                <div>
                                    <strong>Date:</strong>
                                    {{ $event->start_datetime->format('M d, Y') }}
                                    @if($event->start_datetime->format('M d, Y') !== $event->end_datetime->format('M d, Y'))
                                    to {{ $event->end_datetime->format('M d, Y') }}
                                    @endif
                                    <br>
                                    <strong>Time:</strong>
                                    {{ $event->start_datetime->format('h:i A') }}
                                    to {{ $event->end_datetime->format('h:i A') }}
                                </div>
                                @endif
                            </div>
                    
                            <!-- Right Section -->
                            <div class="text-end">
                                <div>
                                    <small class="text-muted">{{ $event->published_at->format('M d, Y') }}</small>
                                </div>
                                <div>
                                    <small class="text-muted">Views: {{ $event->views_count }}</small>
                                </div>
                            </div>
                        </div>
                    
                        <a href="{{ route('events.show', $event->slug) }}" class="btn btn-light"> <i class="bi-eye"></i> View</a>
                    </div>
                    

                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $eventItems->links() }}
        </div>
    </div>
</x-main-layout>
