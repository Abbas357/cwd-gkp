<x-main-layout title="News">
    
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
                <div class="list-group-item py-4">
                    <div class="row">
                        <!-- Conditional Image -->
                        <div class="col-md-2">
                            @if ($news->getFirstMedia('news_attachments') && $news->getFirstMedia('news_attachments')->mime_type === 'image/jpeg')
                                <img src="{{ $news->getFirstMediaUrl('news_attachments') }}" 
                                     alt="{{ $news->title }}" 
                                     class="img-fluid rounded" 
                                     style="max-height: 100px; width: auto;">
                            @else
                                <img src="{{ asset('admin/images/no-image.jpg') }}" 
                                     alt="No image available" 
                                     class="img-fluid rounded" 
                                     style="max-height: 100px; width: auto;">
                            @endif
                        </div>
    
                        <!-- Title, Date, Summary, and Read More on the right -->
                        <div class="col-md-10">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('news.show', $news->slug) }}"><h5 class="mt-0">{{ $news->title }}</h5></a>
                                <small class="text-muted">{{ $news->published_at->format('M d, Y') }}</small>
                            </div>
                            <p class="mb-1">
                                <a href="{{ route('news.index', ['category' => $news->category]) }}" class="text-decoration-none text-primary">
                                    {{ $news->category ?? 'General' }}
                                </a> | 
                                <span>{{ $news->user->designation ?? 'Author' }}</span>
                            </p>
                            <p>{{ Str::limit($news->summary ?? 'No summary available.', 150) }}</p>
                            <a href="{{ route('news.show', $news->slug) }}" class="btn btn-primary btn-sm">Read More</a>
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
