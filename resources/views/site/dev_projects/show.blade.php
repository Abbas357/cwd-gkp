<x-main-layout title="Development Project Details">

    @push('style')
        <link rel="stylesheet" href="{{ asset('admin/plugins/lightbox/lightbox.min.css') }}" />
        <style>
            table, td, th {
                vertical-align: middle
            }
        </style>
    @endpush

    <x-slot name="breadcrumbTitle">
        {{ $projectData['name'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('development_projects.index') }}">Development Projects</a></li>
    </x-slot>

    <div class="container mt-3">

        <div class="d-flex justify-content-between">
            <p><strong>Chief Engineer:</strong> {{ $projectData['chief_engineer'] }}</p>
            <p><strong>Views: </strong> {{ $projectData['views_count'] }}</p>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <tbody>
                    @if(!empty($projectData['name']))
                        <tr>
                            <th>Name</th>
                            <td>{{ $projectData['name'] }}</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['introduction']))
                        <tr>
                            <th>Introduction</th>
                            <td>{!! nl2br($projectData['introduction']) !!}</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['total_cost']))
                        <tr>
                            <th>Total Cost</th>
                            <td>&#8360; {{ number_format($projectData['total_cost'], 2) }} (Millions)</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['commencement_date']))
                        <tr>
                            <th>Commencement Date</th>
                            <td>{{ \Carbon\Carbon::parse($projectData['commencement_date'])->format('M d, Y') }}</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['district']))
                        <tr>
                            <th>District</th>
                            <td>{{ $projectData['district'] }}</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['work_location']))
                        <tr>
                            <th>Work Location</th>
                            <td>{{ $projectData['work_location'] }}</td>
                        </tr>
                    @endif
                    @if(isset($projectData['progress_percentage']))
                        <tr>
                            <th>Progress Percentage</th>
                            <td>{{ $projectData['progress_percentage'] }}%</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['year_of_completion']))
                        <tr>
                            <th>Year of Completion</th>
                            <td>{{ $projectData['year_of_completion'] }}</td>
                        </tr>
                    @endif
                    @if(!empty($projectData['status']))
                        <tr>
                            <th>Status</th>
                            <td>{{ $projectData['status'] }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="images mt-4">
            <h5>Attached Images</h5>
            <div class="row">
                @foreach($projectData['images'] as $image)
                    <div class="col-md-3 mb-3">
                        <a href="{{ $image }}" data-lightbox="project-images" data-title="{{ $projectData['name'] }}">
                            <img src="{{ $image }}" class="img-fluid rounded mb-3" alt="{{ $projectData['name'] }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <div class="container mt-4">
        <h3 class="mb-4">Comments</h3>
            @foreach ($projectData['comments'] as $comment)
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
                            <form class="needs-validation" method="POST" action="{{ route('comments.store', ['type' => 'DevelopmentProject', 'id' => $projectData['id']]) }}" novalidate>
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
        <form class="container needs-validation p-2" method="POST" action="{{ route('comments.store', ['type' => 'DevelopmentProject', 'id' => $projectData['id']]) }}" novalidate>
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

    @push('script')
        <script src="{{ asset('admin/plugins/lightbox/lightbox.min.js') }}"></script>
        <script>
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'disableScrolling': true,
            });

            var forms = document.querySelectorAll('.needs-validation');            
    
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
