<div class="container mt-4">
    <div class="d-flex justify-content-start align-items-center mb-4">
        <h4 class="mb-4"> {{ $comments->count() + $comments->sum(fn($comment) => $comment->replies->count()) }} Comments</h4>

        <div class="mb-3" style="width:7rem; margin-left:2rem">
            <select class="form-select" id="sortComments" onchange="sortComments(this.value)">
                <option>Sort</option>
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
            </select>
        </div>
    </div>

    @foreach ($comments as $comment)
        <div class="card mb-3" style="box-shadow: 0 0 10px #00000025">
            <div class="card-body p-0">
                <div class="d-flex align-items-center mb-2 bg-light p-2 px-3">
                    <div class="me-3">
                        <img src="{{ $comment->user?->getFirstMediaUrl('profile_pictures') ?? $comment->avatar }}" alt="User Avatar" class="rounded-circle" style="width: 40px; height: 40px;">
                    </div>
                    <div>
                        <h6 class="mb-0">
                            @if($comment->name) 
                                {{ $comment->name }} 
                            @else 
                                <a href="{{ route('positions.details', ['uuid' => $comment->user->uuid ]) }}">
                                    {{ $comment->user->position }} 
                                    <i class="bi-patch-check-fill text-info"></i>
                                </a>
                            @endif
                        </h6>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                <p class="mb-0 px-3">{{ $comment->body }}</p>

                <div class="mt-2 p-1 pb-2 px-3 border interact-btns">
                    <button class="btn p-1 pb-0 mt-1"><i class="bi-hand-thumbs-up"></i> &nbsp;Like</button> 
                    <button class="btn p-1 pb-0 mt-1"><i class="bi-hand-thumbs-down"></i> &nbsp;Dislike</button>
                </div>
            </div>

            @if ($comment->replies->isNotEmpty())
                <div class="px-4 py-3">
                    @foreach ($comment->replies as $reply)
                        <div class="border mb-3" style="box-shadow: 0 0 10px #00000025">
                            <div class="d-flex align-items-center mb-2 bg-light p-2 px-3">
                                <div class="me-3">
                                    <img src="{{ $reply->user->getFirstMediaUrl('profile_pictures') ?? $comment->avatar }}" alt="User Avatar" class="rounded-circle" style="width: 40px; height: 40px;">
                                </div>
                                <div>
                                    <h6 class="mb-0">
                                        <a href="{{ route('positions.details', ['uuid' => $reply->user->uuid ]) }}">
                                            {{ $reply->user->position }} 
                                            <i class="bi-patch-check-fill text-info"></i>
                                        </a>
                                    </h6>
                                    <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <p class="mb-2 px-3">{{ $reply->body }}</p>
                            @if($reply->hasMedia('comment_attachments'))
                                <div class="mb-2 px-3">
                                    @php
                                        $media = $reply->getFirstMedia('comment_attachments');
                                        $fileName = $media->name ?? 'Attachment';
                                        $fileType = $media->mime_type ?? null;

                                        $iconMap = [
                                            'image' => 'bi-image',
                                            'pdf' => 'bi-file-earmark-pdf',
                                            'default' => 'bi-paperclip',
                                        ];

                                        $iconClass = $iconMap['default'];
                                        if ($fileType) {
                                            if (str_contains($fileType, 'image')) {
                                                $iconClass = $iconMap['image'];
                                            } elseif (str_contains($fileType, 'pdf')) {
                                                $iconClass = $iconMap['pdf'];
                                            }
                                        }
                                    @endphp

                                    <i class="{{ $iconClass }}"></i>
                                    <a target="_blank" href="{{ $reply->getFirstMediaUrl('comment_attachments') }}"> &nbsp;{{ $fileName }}</a>
                                </div>
                            @endif

                            <div class="mt-2 p-1 pb-2 px-3 border interact-btns">
                                <button class="btn p-1 pb-0 mt-1"><i class="bi-hand-thumbs-up"></i> &nbsp;Like</button> 
                                <button class="btn p-1 pb-0 mt-1"><i class="bi-hand-thumbs-down"></i> &nbsp;Dislike</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach

    @if($commentsAllowed)
    <form class="container needs-validation p-2" method="POST" action="{{ route('comments.store', ['type' => $modelType, 'id' => $modelId]) }}" novalidate>
        @csrf
        <div class="mb-3 d-flex justify-content-between gap-3 inputs d-none">
            <input type="text" name="name" class="form-control" placeholder="Name" required style="flex: 1;" />
            <input type="email" name="email" class="form-control" placeholder="Email" required style="flex: 1;" />
        </div>
        <div class="mb-3">
            <textarea name="body" class="form-control comment-body" rows="2" placeholder="What do you say?" required></textarea>
        </div>
        <button type="reset" class="btn btn-light close-form d-none">Cancel</button>
        <x-button type="submit" data-icon="bi-send" text="Comment" />
    </form>
    @else
    <p class="text-center">Comments are disabled. <a href="#">Learn more</a></p>
    @endif
</div>

<script>
    const commentContainers = document.querySelectorAll('.interact-btns');
    
    commentContainers.forEach(container => {
        const likeButtons = container.querySelectorAll('.btn:nth-child(1)');
        const dislikeButtons = container.querySelectorAll('.btn:nth-child(2)');
        
        likeButtons.forEach(likeBtn => {
            likeBtn.addEventListener('click', () => {
                likeBtn.classList.toggle('text-primary');
                
                const correspondingDislikeBtn = likeBtn.nextElementSibling;
                correspondingDislikeBtn.classList.remove('text-primary');
            });
        });
        
        dislikeButtons.forEach(dislikeBtn => {
            dislikeBtn.addEventListener('click', () => {
                dislikeBtn.classList.toggle('text-primary');
                
                const correspondingLikeBtn = dislikeBtn.previousElementSibling;
                correspondingLikeBtn.classList.remove('text-primary');
            });
        });
    });
    
    document.querySelectorAll('.comment-body').forEach(textarea => {
        textarea.addEventListener('focus', function() {
            const form = this.closest('form');
            const inputs = form.querySelector('.inputs');
            const closeButton = form.querySelector('.close-form');
            inputs.classList.remove('d-none');
            this.setAttribute('rows', 5);
            closeButton.classList.remove('d-none');
        });
    });

    document.querySelectorAll('.close-form').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            const inputs = form.querySelector('.inputs');
            const commentBody = form.querySelector('.comment-body');
            inputs.classList.add('d-none');
            commentBody.setAttribute('rows', 2);
            commentBody.style.display = 'block';
            this.classList.add('d-none');
        });
    });

</script>