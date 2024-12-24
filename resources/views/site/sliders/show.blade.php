<x-main-layout title="{{ $sliderData['title'] }}">

    <x-slot name="breadcrumbTitle">
        {{ $sliderData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Gallery</li>
    </x-slot>
    
    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            <p><strong>Published At:</strong> {{ $sliderData['published_at'] ? $sliderData['published_at']->format('M d, Y') : 'Not Published' }}</p>
            <p><strong>Views:</strong> {{ $sliderData['views_count'] }}</p>
        </div>
        <!-- Responsive Image -->
        <img 
            src="{{ $sliderData['image']['large'] }}" 
            srcset="{{ $sliderData['image']['medium'] }} 800w, {{ $sliderData['image']['large'] }} 1200w" 
            sizes="(max-width: 600px) 400px, (max-width: 1200px) 800px, 1200px" 
            class="img-fluid my-4" 
            alt="{{ $sliderData['title'] }}">


        <div class="description mt-4">
            <h2>Description</h2>
            <p>{!! nl2br($sliderData['description']) !!}</p>
        </div>
    </div>

    <div class="container mt-4">
        <h3 class="mb-4">Comments</h3>
            @foreach ($sliderData['comments'] as $comment)
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
                        <button class="btn p-1 pb-0 mt-1"><i class="bi-hand-thumbs-up"></i></button>
                        <button class="btn p-1 pb-0 mt-1"><i class="bi-hand-thumbs-down"></i></button>
                        <button class="btn p-1 pb-0 mt-1" data-bs-toggle="collapse" data-bs-target="#replyForm-{{ $comment->id }}">Reply</button>

                        <!-- Reply Form (Initially Hidden) -->
                        <div id="replyForm-{{ $comment->id }}" class="collapse mt-3">
                            <form class="needs-validation" method="POST" action="{{ route('comments.store', ['type' => 'Slider', 'id' => $sliderData['id']]) }}" novalidate>
                                @csrf
                                <div class="mb-3 d-flex justify-content-between gap-3 inputs d-none">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" required style="flex: 1;" />
                                    <input type="email" name="email" class="form-control" placeholder="Your Email" style="flex: 1;" />
                                </div>
                                <div class="mb-3">
                                    <textarea name="body" class="form-control comment-body" rows="2" placeholder="Your Reply" required></textarea>
                                </div>
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                                <button type="reset" class="btn btn-light close-form d-none">Cancel</button>
                                <button type="submit" class="cw-btn">Post Reply</button>
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
        <form class="container needs-validation p-2" method="POST" action="{{ route('comments.store', ['type' => 'Slider', 'id' => $sliderData['id']]) }}" novalidate>
            @csrf
            <div class="mb-3 d-flex justify-content-between gap-3 inputs d-none">
                <input type="text" name="name" class="form-control" placeholder="Your Name" required style="flex: 1;" />
                <input type="email" name="email" class="form-control" placeholder="Your Email" style="flex: 1;" />
            </div>
            <div class="mb-3">
                <textarea name="body" class="form-control comment-body" rows="2" placeholder="Your Comment" required></textarea>
            </div>
            <input type="hidden" name="parent_id" value="" />
            <button type="reset" class="btn btn-light close-form d-none">Cancel</button>
            <button type="submit" class="cw-btn"><i class="bi-send"></i> &nbsp; Comment</button>
        </form>
    </div>

    @push('script')
        <script>
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

            $('.comment-body').on('focus', function() {
                $(this).closest('form').find('.inputs').removeClass('d-none');
                $(this).closest('form').find('.close-form').removeClass('d-none');
            });

            $('.close-form').on('click', function() {
                $(this).closest('form').find('.inputs').addClass('d-none');
                $(this).addClass('d-none');
            });

        </script>
    @endpush
</x-main-layout>
