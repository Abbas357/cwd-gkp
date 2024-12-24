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

    <div class="container mt-4">
        <h3 class="mb-4">Comments</h3>
            @foreach ($eventData['comments'] as $comment)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <!-- Comment Header -->
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-3">
                                <img src="{{ asset('site/images/default-dp.png') }}" alt="User Avatar" class="rounded-circle" style="width: 40px; height: 40px;">
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $comment->name }}</h6>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <!-- Comment Body -->
                        <p class="mb-0">{{ $comment->body }}</p>

                        <!-- Reply Button -->
                        <button class="btn btn-link p-0 mt-2" data-bs-toggle="collapse" data-bs-target="#replyForm-{{ $comment->id }}">Reply</button>

                        <!-- Reply Form (Initially Hidden) -->
                        <div id="replyForm-{{ $comment->id }}" class="collapse mt-3">
                            <form class="needs-validation" method="POST" action="{{ route('comments.store', ['type' => 'Event', 'id' => $eventData['id']]) }}" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" required />
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Your Email" required />
                                </div>
                                <div class="mb-3">
                                    <textarea name="body" class="form-control" rows="3" placeholder="Your Reply" required></textarea>
                                </div>
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                                <button type="submit" class="btn btn-primary">Post Reply</button>
                            </form>
                        </div>
                    </div>

                    <!-- Replies Section -->
                    @if ($comment->replies->isNotEmpty())
                        <div class="bg-light border-top">
                            <div class="px-4 py-3">
                                @foreach ($comment->replies as $reply)
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="me-3">
                                            <img src="{{ asset('site/images/default-dp.png') }}" alt="User Avatar" class="rounded-circle" style="width: 30px; height: 30px;">
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $reply->name }}</h6>
                                            <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                            <p class="mb-0">{{ $reply->body }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Main Comment Form -->
        <form class="container needs-validation p-2" method="POST" action="{{ route('comments.store', ['type' => 'Event', 'id' => $eventData['id']]) }}" novalidate>
            @csrf
            <div class="mb-3 d-flex justify-content-between gap-3">
                <input type="text" name="name" class="form-control" placeholder="Your Name" required style="flex: 1;" />
                <input type="email" name="email" class="form-control" placeholder="Your Email" style="flex: 1;" />
            </div>
            <div class="mb-3">
                <textarea name="body" class="form-control" rows="3" placeholder="Your Comment" required></textarea>
            </div>
            <input type="hidden" name="parent_id" value="" />
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/lightbox/lightbox.min.js') }}"></script>
    <script>
        lightbox.option({
            'resizeDuration': 200
            , 'wrapAround': true
            , 'disableScrolling': true
        , });

        var forms = document.querySelectorAll('.needs-validation')
    
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        });


    </script>
    @endpush
</x-main-layout>
