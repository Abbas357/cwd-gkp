<div class="container-fluid blog py-3">
    <div class="container py-2">
        <div class="mx-auto text-center" style="max-width: 900px;">
            <h5 class="section-title px-3 my-5">Our Blog</h5>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach ($allNews as $news)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item">
                        <div class="blog-img">
                            <div class="blog-img-inner">
                                <!-- Dynamic image from $news with fallback -->
                                <img class="img-fluid w-100 rounded-top" src="{{ $news['image'] }}" alt="{{ $news['title'] }}">
                                <div class="blog-icon">
                                    <a href="{{ route('news.show', $news['slug']) }}" class="my-auto"><i class="bi bi-link fs-1 text-white"></i></a>
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
                            <!-- Dynamic author and title -->
                            <a href="{{ route('news.show', $news['slug']) }}" class="h4">{{ $news['title'] }}</a>
                            <!-- Dynamic summary -->
                            <p class="my-3">{{ Str::limit($news['summary'], 100, '...') }}</p>
                            <a href="{{ route('news.show', $news['slug']) }}" class="btn-animate rounded-pill py-2 px-4">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
