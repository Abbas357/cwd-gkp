<x-main-layout title="News">
    @push('style')
    <style>
        .list-group-item {
            display: block !important;
            margin-block: .7rem;
            box-shadow: 2px 3px 5px #00000011, -2px -3px 5px #00000011;
        }

        .news-attachment {
            width: 170px;
            height: 110px
        }

    </style>
    @endpush
    <x-slot name="breadcrumbTitle">
        News
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">News</li>
    </x-slot>

    <div class="container my-4">

        <div class="mb-4">
            <form method="GET" action="{{ route('news.index') }}">
                <div class="d-flex align-items-center">
                    <label for="category" class="me-2">Filter by Category:</label>
                    <select name="category" id="category" class="form-select w-auto" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- News List -->
        <div class="list-group">
            @foreach ($newsItems as $news)
            <div class="list-group-item py-2">
                <div class="row">
                    <div class="col-md-2">
                        @if ($news->getFirstMedia('news_attachments') && $news->getFirstMedia('news_attachments')->mime_type === 'image/jpeg')
                        <img src="{{ $news->getFirstMediaUrl('news_attachments') }}" alt="{{ $news->title }}" class="img-fluid rounded news-attachment">
                        @else
                        <img src="{{ asset('admin/images/no-image.jpg') }}" alt="No image available" class="img-fluid rounded news-attachment">
                        @endif
                    </div>

                    <div class="col-md-10">
                        <div class="mb-0">
                            @if($news->category)
                            <a href="{{ route('news.index', ['category' => $news->category]) }}" class="badge bg-info text-dark">
                                {{ $news->category }}
                            </a>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between">
                            <!-- Left Section -->
                            <div>
                                <a href="{{ route('news.show', $news->slug) }}">
                                    <h5 class="mt-0">{{ $news->title }}</h5>
                                </a>
                                
                                <p class="mb-0">{{ Str::limit($news->summary ?? 'No summary available.', 100) }}</p>
                            </div>
                    
                            <!-- Right Section -->
                            <div class="text-end">
                                @if($news->published_at)
                                <div>
                                    <small class="text-muted">{{ $news->published_at->format('M d, Y') }}</small>
                                </div>
                                @endif
                                <div>
                                    <small class="text-muted"><span class="fw-bold">Views: </span>{{ $news->views_count }}</small>
                                </div>
                            </div>
                        </div>
                    
                        <a href="{{ route('news.show', $news->slug) }}" class="btn btn-light"><i class="bi-eye"></i> View</a>
                    </div>
                    
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $newsItems->links() }}
        </div>
    </div>
</x-main-layout>
