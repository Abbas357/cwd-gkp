<x-main-layout title="{{ $newsData['title'] }}">

    @push('style')
    <style>
        #commentForm {
            margin: auto;
            margin-top: 1.5rem;
            border: 1px solid #ddd;
        }

        #commentForm .btn {
            background: linear-gradient(90deg, #007bff, #0056b3);
            border: none;
            color: #fff;
            font-weight: bold;
            padding: 10px 20px;
            text-transform: uppercase;
            transition: background 0.3s ease;
        }

        #commentForm .btn:hover {
            background: linear-gradient(90deg, #0056b3, #007bff);
        }

        #commentForm {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #commentForm input::placeholder,
        #commentForm textarea::placeholder {
            font-style: italic;
            color: #6c757d;
        }
    </style>
    @endpush

    <x-slot name="breadcrumbTitle">
        {{ $newsData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">News</li>
    </x-slot>

    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            @if (!empty($newsData['published_at']))
            <p><strong>Published At:</strong> {{ $newsData['published_at'] }}</p>
            @endif
            <p><strong>Views:</strong> {{ $newsData['views_count'] }}</p>
        </div>

        <div class="description mt-4">
            <p>{!! nl2br($newsData['content'] ?? 'No content available.') !!}</p>
        </div>

        @if (!empty($newsData['file_url']))
        <div class="attachment mt-4">
            <h3>Attachment</h3>
            <a href="{{ $newsData['file_url'] }}" target="_blank">
                Download ({{ strtoupper(pathinfo($newsData['file_url'], PATHINFO_EXTENSION)) }})
            </a>

            <div class="mt-2">
                @if (str_starts_with($newsData['file_type'], 'image'))
                <img src="{{ $newsData['file_url'] }}" alt="{{ $newsData['title'] }}" style="max-width:100%; height:auto;">
                @endif
            </div>
        </div>
        @else
        <p>No attachment available.</p>
        @endif
 
        <div class="container mt-4">
            <h5 class="sharer-title">Share this news</h5>
            @php
                $title = $newsData['title'] . ' - ' . config('app.name');
            @endphp
            <div class="sharer-container">
                <div class="sharer-button" data-sharer="email" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                    <i class="bi bi-envelope-fill"></i>
                    <span>Email</span>
                </div>
                <div class="sharer-button" data-sharer="whatsapp" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                    <i class="bi bi-whatsapp"></i>
                    <span>WhatsApp</span>
                </div>
                <div class="sharer-button" data-sharer="facebook" data-url="{{ url()->current() }}">
                    <i class="bi bi-facebook"></i>
                    <span>Facebook</span>
                </div>
                <div class="sharer-button" data-sharer="twitter" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                    <i class="bi bi-twitter-x"></i>
                    <span>X</span>
                </div>
                <div class="sharer-button" data-sharer="threads" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                    <i class="bi bi-threads"></i>
                    <span>Threads</span>
                </div>
                <div class="sharer-button" data-sharer="linkedin" data-url="{{ url()->current() }}">
                    <i class="bi bi-linkedin"></i>
                    <span>LinkedIn</span>
                </div>
                <div class="sharer-button" data-sharer="telegram" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                    <i class="bi bi-telegram"></i>
                    <span>Telegram</span>
                </div>
                <div class="sharer-button" data-sharer="reddit" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                    <i class="bi bi-reddit"></i>
                    <span>Reddit</span>
                </div>
                <div class="sharer-button" data-sharer="pinterest" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                    <i class="bi bi-pinterest"></i>
                    <span>Pinterest</span>
                </div>
            </div>
        </div>
     

        <div class="container mt-4">
            <h3 class="mb-4">Comments</h3>
                @foreach ($newsData['comments'] as $comment)
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
                                <form class="needs-validation" method="POST" action="{{ route('comments.store', ['type' => 'News', 'id' => $newsData['id']]) }}" novalidate>
                                    @csrf
                                    <div class="mb-3 d-flex justify-content-between gap-3 inputs d-none">
                                        <input type="text" name="name" class="form-control" placeholder="Your Name" required style="flex: 1;" />
                                        <input type="email" name="email" class="form-control" placeholder="Your Email" required style="flex: 1;" />
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
            <form class="container needs-validation p-2" method="POST" action="{{ route('comments.store', ['type' => 'News', 'id' => $newsData['id']]) }}" novalidate>
                @csrf
                <div class="mb-3 d-flex justify-content-between gap-3 inputs d-none">
                    <input type="text" name="name" class="form-control" placeholder="Your Name" required style="flex: 1;" />
                    <input type="email" name="email" class="form-control" placeholder="Your Email" required style="flex: 1;" />
                </div>
                <div class="mb-3">
                    <textarea name="body" class="form-control comment-body" rows="2" placeholder="Your Comment" required></textarea>
                </div>
                <input type="hidden" name="parent_id" value="" />
                <button type="reset" class="btn btn-light close-form d-none">Cancel</button>
                <button type="submit" class="cw-btn"><i class="bi-send"></i> &nbsp; Comment</button>
            </form>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('site/lib/sharer/sharer.min.js') }}"></script>
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
                $(this).attr('rows', 5);
                $(this).closest('form').find('.close-form').removeClass('d-none');
            });

            $('.close-form').on('click', function() {
                $(this).closest('form').find('.inputs').addClass('d-none');
                $(this).closest('form').find('.comment-body').hide().attr('rows', 2).show();
                $(this).addClass('d-none');
            });

        </script>
    @endpush

</x-main-layout>
