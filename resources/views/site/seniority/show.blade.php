<x-main-layout title="{{ $seniorityData['title'] }}">

    @push('style')
    <link rel="stylesheet" href="{{ asset('admin/plugins/lightbox/lightbox.min.css') }}" />
    @endpush

    <x-slot name="breadcrumbTitle">{{ $seniorityData['title'] }}</x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('seniority.index') }}">Seniority List</a></li>
        <li class="breadcrumb-item active">{{ $seniorityData['title'] }}</li>
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
                </tbody>
            </table>
        </div>

        <!-- Attachment (Media) Section with Lightbox -->
        @if ($seniorityData['attachment'])
        <div class="mt-4">
            <h5>Attachment</h5>
            <a href="{{ $seniorityData['attachment'] }}" download>
                Download Attachment
            </a>
        </div>
        @endif
    </div>

    <div class="container mt-4">
        <h3 class="mb-4">Comments</h3>
            @foreach ($seniorityData['comments'] as $comment)
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
                            <form class="needs-validation" method="POST" action="{{ route('comments.store', ['type' => 'Seniority', 'id' => $seniorityData['id']]) }}" novalidate>
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
        <form class="container needs-validation p-2" method="POST" action="{{ route('comments.store', ['type' => 'Seniority', 'id' => $seniorityData['id']]) }}" novalidate>
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
            'resizeDuration': 200,
            'wrapAround': true,
            'disableScrolling': true,
        });

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