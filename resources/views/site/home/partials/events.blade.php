<link href="{{ asset('site/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

<div class="events-carousel owl-carousel">
    @foreach ($events as $event)
    <div class="events-item" style="overflow: hidden">
        <div class="events-img" style="height:300px">
            <img src="{{ $event['image'] }}" style="height:300px" class="img-fluid w-100 rounded-top" alt="{{ $event['title'] }}">
            <div class="events-info d-flex border border-start-0 border-end-0 position-absolute" style="width: 100%; bottom: 0; left: 0; z-index: 5;">
                <small class="flex-fill text-center border-end py-2"><i class="bi-geo-alt me-2"></i>{{ $event['location'] }}</small>
                <small class="flex-fill text-center py-2"><i class="bi-people-fill me-2"></i>{{ $event['no_of_participants'] }} Participants</small>
            </div>
        </div>
        <div class="events-content bg-light">
            @if(!empty($event['start_datetime']) && !empty($event['end_datetime']))
            <div class="flex-fill text-center">
                <i class="bi-calendar-check me-2"></i>
                <td>
                    {{ \Carbon\Carbon::parse($event['start_datetime'])->format('M d, Y') }}
                    @if(\Carbon\Carbon::parse($event['start_datetime'])->format('M d, Y') != \Carbon\Carbon::parse($event['end_datetime'])->format('M d, Y'))
                    to {{ \Carbon\Carbon::parse($event['end_datetime'])->format('M d, Y') }}
                    @endif
                </td>
            </div>
            <div class="flex-fill text-center">
                <i class="bi-alarm me-2"></i>
                <td>
                    {{ \Carbon\Carbon::parse($event['start_datetime'])->format('h:i A') }}
                    to {{ \Carbon\Carbon::parse($event['end_datetime'])->format('h:i A') }}
                </td>
            </div>
            @elseif(!empty($event['start_datetime']))
            <div class="flex-fill text-center">
                <i class="bi-calendar-check me-2"></i>
                <td>{{ \Carbon\Carbon::parse($event['start_datetime'])->format('M d, Y') }}</td>
            </div>
            <div class="flex-fill text-center">
                <i class="bi-alarm me-2"></i>
                <td>{{ \Carbon\Carbon::parse($event['start_datetime'])->format('h:i A') }}</td>
            </div>
            @endif
            
            <div class="p-3 pb-0 mb-2 text-center">
                <h5 class="mb-2" style="white-space: nowrap">{{ \Illuminate\Support\Str::limit($event['title'], 50) }}</h5>
            </div>
            <div class="row bg-light rounded-bottom mx-0">
                <div class="col text-center px-0">
                    <a href="{{ route('events.show', $event['slug']) }}" class="cw-btn py-2 px-4">Read More</a>
                </div>
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
        center: true,
        dots: true,
        loop: true,
        margin: 25,
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
