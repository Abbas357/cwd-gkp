<link href="{{ asset('site/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

<style>
    .text-no-overflow {
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>

<div class="team-carousel owl-carousel">
    @foreach ($users as $user)
    <div class="team-item">
        <div class="team-img">
            <div class="team-img-efects">
                <img src="{{ $user['image'] }}" class="img-fluid w-100 rounded-top" alt="{{ $user['name'] }}">
            </div>
            <div class="team-icon rounded-pill p-1" style="background-color: #ffffff55;">
                <a class="btn btn-square btn-primary rounded-circle mx-1" href="{{ $user['facebook'] }}" target="_blank"><i class="bi bi-facebook"></i></a>
                <a class="btn btn-square btn-dark rounded-circle mx-1" href="{{ $user['twitter'] }}" target="_blank"><i class="bi bi-twitter-x"></i></a>
                <a class="btn btn-square btn-success rounded-circle mx-1" href="https://wa.me/{{ $user['whatsapp'] }}" target="_blank"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>
        <div class="team-title text-center rounded-bottom p-1">
            <div class="team-title-inner">
                <h4 class="mt-4 fs-5 text-no-overflow">{{ $user['name'] }}</h4>
                <p class="mb-2 text-no-overflow">{{ $user['position'] }}</p>
                <a href="{{ route('positions.details', ['id' => $user['id'] ]) }}" class="cw-btn">View Detail</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script src="{{ asset('site/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script>
    $(".team-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: true,
        dots: true,
        loop: true,
        margin: 25,
        nav: true,
        navText: [
            '<i class="bi bi-arrow-left"></i>', '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0: {
                items: 2
            },
            768: {
                items: 3
            },
            992: {
                items: 4
            },
            1200: {
                items: 5
            }
        }
    });
</script>