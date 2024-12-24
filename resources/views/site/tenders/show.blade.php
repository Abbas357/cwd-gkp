<x-main-layout title="{{ $tenderData['title'] }}">

    <x-slot name="breadcrumbTitle">
        {{ $tenderData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Tenders</li>
    </x-slot>

    <div class="container mt-3">
        <p style="text-align: right"><strong>Views:</strong> {{ $tenderData['views_count'] }}</p>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped mt-4">
                    <tbody>
                        @if (!empty($tenderData['published_by']) || !empty($tenderData['published_at']))
                        <tr>
                            <th>Procurement Entity</th>
                            <td>{{ $tenderData['procurement_entity'] ?? 'Not Provided' }}</td>
                        </tr>
                        <tr>
                            <th>Date of Advertisement</th>
                            <td>{{ $tenderData['date_of_advertisement'] ?? 'Not Provided' }}</td>
                        </tr>
                        <tr>
                            <th>Closing Date</th>
                            <td>{{ $tenderData['closing_date'] ?? 'Not Provided' }}</td>
                        </tr>
                        <tr>
                            <th>Tender Domain</th>
                            <td>{{ $tenderData['domain'] }}</td>
                        </tr>
                        <tr>
                            <th>Office</th>
                            <td>{{ $tenderData['user'] ?? 'Not Provided' }}</td>
                        </tr>
                        <tr>
                            <th>Published By</th>
                            <td>{{ $tenderData['published_by'] ?? 'Not Provided' }}</td>
                        </tr>
                        <tr>
                            <th>Published At</th>
                            <td>{{ $tenderData['published_at'] ?? 'Not Provided' }}</td>
                        </tr>
                        @endif

                        <tr>
                            <th>Description</th>
                            <td>{!! nl2br($tenderData['description']) !!}</td>
                        </tr>

                        {{-- Tender Documents --}}
                        <tr>
                            <th>Tender Documents</th>
                            <td>
                                <ul class="list-group">
                                    @forelse ($tenderData['tender_documents'] as $doc)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ $doc['url'] }}" target="_blank">
                                           <i class="{{ getDocumentIcon($doc['type']) }} text-danger"></i> {{ $doc['name'] }} 
                                        </a>
                                    </li>
                                    @empty
                                    No Tender Documents
                                    @endforelse
                                </ul>
                            </td>
                        </tr>

                        {{-- EOI Documents --}}
                        <tr>
                            <th>EOI Documents</th>
                            <td>
                                <ul class="list-group">
                                    @forelse ($tenderData['tender_eoi_documents'] as $doc)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ $doc['url'] }}" target="_blank">
                                            <i class="{{ getDocumentIcon($doc['type']) }} text-danger"></i> {{ $doc['name'] }}
                                        </a>
                                    </li>
                                    @empty
                                    No EOI Documents
                                    @endforelse
                                </ul>
                            </td>
                        </tr>

                        {{-- Bidding Documents --}}
                        <tr>
                            <th>Bidding Documents</th>
                            <td>
                                <ul class="list-group">
                                    @forelse ($tenderData['bidding_documents'] as $doc)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ $doc['url'] }}" target="_blank">
                                            <i class="{{ getDocumentIcon($doc['type']) }} text-danger"></i> {{ $doc['name'] }}
                                        </a>
                                    </li>
                                    @empty
                                    No Bidding Documents
                                    @endforelse
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>

                @if (empty($tenderData['tender_documents']) && empty($tenderData['tender_eoi_documents']) && empty($tenderData['bidding_documents']))
                <p>No documents available.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <h3 class="mb-4">Comments</h3>
            @foreach ($tenderData['comments'] as $comment)
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
                            <form class="needs-validation" method="POST" action="{{ route('comments.store', ['type' => 'Tender', 'id' => $tenderData['id']]) }}" novalidate>
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
        <form class="container needs-validation p-2" method="POST" action="{{ route('comments.store', ['type' => 'Tender', 'id' => $tenderData['id']]) }}" novalidate>
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
        </script>
    @endpush

</x-main-layout>
