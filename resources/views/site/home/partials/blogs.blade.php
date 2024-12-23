<div class="row g-4 justify-content-center">
    @foreach ($allNews as $news)
    <div class="col-lg-4 col-md-6">
        <div class="blog-item">
            <div class="blog-img">
                <div class="blog-img-inner" style="height:300px">
                    @if (str_starts_with($news['file_type'], 'image'))
                    <!-- Display image if the file is an image -->
                    <img class="img-fluid w-100 rounded-top" src="{{ $news['image'] }}" alt="{{ $news['title'] }}">
                    @else
                    <!-- Display a placeholder if the file is not an image -->
                    <img class="img-fluid w-100 rounded-top" src="{{ asset('admin/images/no-image.jpg') }}" alt="File Placeholder">
                    @endif

                    <div class="blog-icon">
                        <a href="{{ route('news.show', $news['slug']) }}" class="my-auto">
                            <i class="bi bi-link fs-1 text-white"></i>
                        </a>
                    </div>
                </div>
                <div class="blog-info bg-secondary d-flex align-items-center border border-start-0 border-end-0">
                    <small class="flex-fill text-center border-end py-2">
                        <i class="bi bi-calendar-date text-white me-2"></i>{{ $news['published_at'] }}
                    </small>
                    <small class="flex-fill text-center border-end py-2">
                        <i class="bi bi-person text-white me-2"></i>Posted By: {{ $news['author'] }}
                    </small>
                </div>
            </div>
            <div class="blog-content border border-top-0 rounded-bottom p-4">
                <a href="{{ route('news.show', $news['slug']) }}" class="h4">{{ $news['title'] }}</a>
                <div class="text-center">
                    <a href="{{ route('news.show', $news['slug']) }}" class="cw-btn rounded-pill py-2 px-4"><i class="bi-eye"></i> View</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
