<link href="{{ asset('site/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('site/lib/owlcarousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">

<style>
    .news-carousel {
        padding: 20px 0;
    }
    
    .news-item {
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: 15px 0;
        overflow: hidden;
        background-color: white;
    }
    
    .news-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .news-img {
        position: relative;
        overflow: hidden;
        height: 300px;
    }
    
    .news-img-inner {
        height: 300px;
        position: relative;
        overflow: hidden;
    }
    
    .news-img-inner img {
        transition: transform 0.5s ease;
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
    
    .news-item:hover .news-img-inner img {
        transform: scale(1.1);
    }
    
    .news-icon {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .news-item:hover .news-icon {
        opacity: 1;
    }
    
    .news-info {
        background-color: rgba(255, 255, 255, 0.9);
        border: none !important;
        font-weight: 500;
    }
    
    .news-info small {
        font-size: 14px;
        color: #fff;
    }
    
    .news-info i {
        color: #fff;
    }
    
    .news-content {
        padding: 20px;
        background: white !important;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }
    
    .news-content h4 {
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
        font-size: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        height: 52px;
    }
    
    .owl-nav button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: white !important;
        width: 46px;
        height: 46px;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .owl-nav button:hover {
        background: #ff6b6b !important;
    }
    
    .owl-nav button:hover i {
        color: white;
    }
    
    .owl-nav button i {
        font-size: 20px;
        color: #ff6b6b;
        transition: all 0.3s ease;
    }
    
    .owl-nav .owl-prev {
        left: -23px;
    }
    
    .owl-nav .owl-next {
        right: -23px;
    }
    
    .owl-dots {
        margin-top: 20px;
    }
    
    .owl-dots .owl-dot span {
        background: #ddd !important;
        transition: all 0.3s ease;
    }
    
    .owl-dots .owl-dot.active span {
        background: #ff6b6b !important;
        width: 30px;
    }
</style>

<div class="news-carousel owl-carousel">
    @foreach ($allNews as $news)
    <div class="news-item">
        <div class="news-img">
            <div class="news-img-inner">
                @if (str_starts_with($news['file_type'], 'image'))
                <!-- Display image if the file is an image -->
                <img class="img-fluid rounded-top" src="{{ $news['image'] }}" alt="{{ $news['title'] }}">
                @else
                <!-- Display a placeholder if the file is not an image -->
                <img class="img-fluid rounded-top" src="{{ asset('admin/images/no-image.jpg') }}" alt="File Placeholder">
                @endif
                <div class="news-icon">
                    <a href="{{ route('news.show', $news['slug']) }}" class="my-auto">
                        <i class="bi bi-link fs-1 text-white"></i>
                    </a>
                </div>
            </div>
            <div class="news-info bg-secondary d-flex align-items-center border border-start-0 border-end-0">
                <small class="flex-fill text-center border-end py-2">
                    <i class="bi bi-calendar-date me-2"></i>{{ $news['published_at'] }}
                </small>
                <small class="flex-fill text-center py-2">
                    <i class="bi bi-person me-2"></i>{{ $news['author'] }}
                </small>
            </div>
        </div>
        <div class="news-content border border-top-0 rounded-bottom p-4">
            <a href="{{ route('news.show', $news['slug']) }}" class="h4">{{ $news['title'] }}</a>
            <div class="text-center mt-3">
                <a href="{{ route('news.show', $news['slug']) }}" class="cw-btn rounded-pill py-2 px-4"><i class="bi-eye me-1"></i> View</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script src="{{ asset('site/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script>
    $(".news-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: false,
        dots: true,
        loop: true,
        margin: 30,
        nav: true,
        navText: [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0: { items: 1 },
            768: { items: 2 },
            992: { items: 3 },
            1200: { items: 3 }
        }
    });
</script>