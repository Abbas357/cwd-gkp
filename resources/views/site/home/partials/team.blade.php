<link href="{{ asset('site/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
<div class="container py-2">
    <div class="mx-auto text-center" style="max-width: 900px;">
        <h5 class="section-title my-5 px-3">Meet Our Team</h5>
    </div>
    <div class="team-carousel owl-carousel">
        @foreach ($users as $user)
        <div class="team-item">
            <div class="team-img">
                <div class="team-img-efects">
                    <img src="{{ $user['image'] }}" class="img-fluid w-100 rounded-top" alt="{{ $user['name'] }}">
                </div>
                <div class="team-icon rounded-pill p-2">
                    <a class="btn btn-square btn-primary rounded-circle mx-1" href="{{ $user['facebook'] }}" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a class="btn btn-square btn-primary rounded-circle mx-1" href="{{ $user['twitter'] }}" target="_blank"><i class="bi bi-twitter"></i></a>
                    <a class="btn btn-square btn-primary rounded-circle mx-1" href="https://wa.me/{{ $user['whatsapp'] }}" target="_blank"><i class="bi bi-whatsapp"></i></a>
                    <a class="btn btn-square btn-primary rounded-circle mx-1" href="tel:{{ $user['mobile_number'] }}" target="_blank"><i class="bi bi-telephone"></i></a>
                </div>
            </div>
            <div class="team-title text-center rounded-bottom p-4">
                <div class="team-title-inner">
                    <!-- Name and Designation -->
                    <h4 class="mt-3">{{ $user['name'] }}</h4>
                    <p class="mb-3">{{ $user['designation'] }}</p>
                    <a href="{{ route('positions.show', ['designation' => $user['designation']]) }}" class="btn-animate">View Previous</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script src="{{ asset('site/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script>
    $(".team-carousel").owlCarousel({
        autoplay: true
        , smartSpeed: 1000
        , center: true
        , dots: true
        , loop: true
        , margin: 25
        , nav: true
        , navText: [
            '<i class="bi bi-arrow-left"></i>'
            , '<i class="bi bi-arrow-right"></i>'
        ]
        , responsiveClass: true
        , responsive: {
            0: {
                items: 2
            }
            , 768: {
                items: 3
            }
            , 992: {
                items: 4
            }
            , 1200: {
                items: 5
            }
        }
    });

</script>
