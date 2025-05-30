<link href="{{ asset('site/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('site/lib/owlcarousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">

<style>
    .events-carousel {
        padding: 20px 0;
    }
    
    .events-item {
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: 15px 0;
        overflow: hidden;
        background-color: white;
    }
    
    .events-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .events-img {
        position: relative;
        overflow: hidden;
        height: 300px;
    }
    
    .events-img img {
        transition: transform 0.5s ease;
        object-fit: cover;
        height: 300px;
        width: 100%;
    }
    
    .events-item:hover .events-img img {
        transform: scale(1.1);
    }
    
    .events-info {
        background-color: rgba(255, 255, 255, 0.9);
        border: none !important;
        font-weight: 500;
    }
    
    .events-info small {
        font-size: 14px;
        color: #555;
    }
    
    .events-info i {
        color: #ff6b6b;
    }
    
    .events-content {
        padding: 20px;
        background: white !important;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }
    
    .events-content h5 {
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
        font-size: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .date-time-info {
        margin: 10px 0;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 8px;
        font-size: 14px;
        color: #555;
    }
    
    .date-time-info i {
        color: #ff6b6b;
        margin-right: 5px;
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

<div class="events-carousel owl-carousel">
    @foreach ($events as $event)
    <div class="events-item">
        <div class="events-img">
            <img src="{{ $event['image'] }}" class="img-fluid rounded-top" alt="{{ $event['title'] }}">
            <div class="events-info d-flex position-absolute">
                <small class="flex-fill text-center border-end py-2"><i class="bi bi-geo-alt me-2"></i>{{ $event['location'] }}</small>
                <small class="flex-fill text-center py-2"><i class="bi bi-people-fill me-2"></i>{{ $event['no_of_participants'] }} Participants</small>
            </div>
        </div>
        <div class="events-content">
            <div class="date-time-info">
                @if(!empty($event['start_datetime']) && !empty($event['end_datetime']))
                <div class="flex-fill text-center mb-2">
                    <i class="bi bi-calendar-check"></i>
                    {{ \Carbon\Carbon::parse($event['start_datetime'])->format('M d, Y') }}
                    @if(\Carbon\Carbon::parse($event['start_datetime'])->format('M d, Y') != \Carbon\Carbon::parse($event['end_datetime'])->format('M d, Y'))
                    to {{ \Carbon\Carbon::parse($event['end_datetime'])->format('M d, Y') }}
                    @endif
                </div>
                <div class="flex-fill text-center">
                    <i class="bi bi-alarm"></i>
                    {{ \Carbon\Carbon::parse($event['start_datetime'])->format('h:i A') }}
                    to {{ \Carbon\Carbon::parse($event['end_datetime'])->format('h:i A') }}
                </div>
                @elseif(!empty($event['start_datetime']))
                <div class="flex-fill text-center mb-2">
                    <i class="bi bi-calendar-check"></i>
                    {{ \Carbon\Carbon::parse($event['start_datetime'])->format('M d, Y') }}
                </div>
                <div class="flex-fill text-center">
                    <i class="bi bi-alarm"></i>
                    {{ \Carbon\Carbon::parse($event['start_datetime'])->format('h:i A') }}
                </div>
                @endif
            </div>
            
            <div class="text-center mb-4">
                <h5>{{ \Illuminate\Support\Str::limit($event['title'], 50) }}</h5>
            </div>
            <div class="text-center">
                <a href="{{ route('events.show', $event['slug']) }}" class="cw-btn">Read More</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script src="{{ asset('site/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script>
    $(".events-carousel").owlCarousel({
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