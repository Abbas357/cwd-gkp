<link href="{{ asset('site/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

<div class="team-section py-5">
    <div class="container-fluid px-4">
        <div class="team-carousel owl-carousel">
            @foreach ($users as $user)
            <div class="team-item">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="{{ $user['image'] }}" class="img-fluid" alt="{{ $user['name'] }}">
                        <div class="team-overlay">
                            <div class="team-social-icons">
                                <a class="social-btn facebook" href="{{ $user['facebook'] }}" target="_blank" aria-label="Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a class="social-btn twitter" href="{{ $user['twitter'] }}" target="_blank" aria-label="Twitter">
                                    <i class="bi bi-twitter-x"></i>
                                </a>
                                <a class="social-btn whatsapp" href="https://wa.me/{{ $user['whatsapp'] }}" target="_blank" aria-label="WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="team-content">
                        <h4 class="team-name">{{ $user['name'] }}</h4>
                        <p class="team-position">{{ $user['posting'] }}</p>
                        <div class="team-action">
                            <a href="{{ route('positions.details', ['uuid' => $user['uuid'] ]) }}" class="view-profile-btn">
                                View Profile <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
/* Team Section Styling */
.team-section {
    background-color: #f8f9fa;
}

/* Team Card Styling */
.team-card {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background-color: #fff;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
    margin: 10px 5px 30px;
}

.team-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
}

/* Team Image Styling */
.team-img-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 12px 12px 0 0;
    height: 0;
    padding-bottom: 100%; /* Creates a perfect square aspect ratio */
}

.team-img-wrapper img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.team-card:hover .team-img-wrapper img {
    transform: scale(1.08);
}

/* Team Overlay with Social Icons */
.team-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.7));
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.4s ease;
}

.team-card:hover .team-overlay {
    opacity: 1;
}

/* Social Icons Styling */
.team-social-icons {
    display: flex;
    gap: 10px;
    transform: translateY(20px);
    transition: transform 0.4s ease;
}

.team-card:hover .team-social-icons {
    transform: translateY(0);
}

.social-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.social-btn:hover {
    transform: scale(1.15);
}

.social-btn.facebook {
    background-color: #3b5998;
}

.social-btn.twitter {
    background-color: #000000;
}

.social-btn.whatsapp {
    background-color: #25d366;
}

/* Team Content Styling */
.team-content {
    padding: 1.5rem 1.2rem;
    text-align: center;
}

.team-name {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #333;
}

.team-position {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 15px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* View Profile Button */
.view-profile-btn {
    display: inline-block;
    padding: 8px 24px;
    background: var(--cw-primary);
    color: #fff;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    border: none;
}

.view-profile-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    color: #fff;
}

/* Carousel Navigation Styling */
.owl-nav button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 44px;
    height: 44px;
    border-radius: 50% !important;
    background-color: #fff !important;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1) !important;
    color: #333 !important;
    font-size: 1.2rem !important;
    transition: all 0.3s ease;
    display: flex !important;
    align-items: center;
    justify-content: center;
}

.owl-nav button:hover {
    background-color: #0d6efd !important;
    color: #fff !important;
}

.owl-nav .owl-prev {
    left: -22px;
}

.owl-nav .owl-next {
    right: -22px;
}

.owl-dots {
    margin-top: 20px;
}

.owl-dots .owl-dot span {
    width: 10px;
    height: 10px;
    margin: 5px;
    background: #d6d6d6;
    border-radius: 30px;
    transition: all 0.3s ease;
}

.owl-dots .owl-dot.active span,
.owl-dots .owl-dot:hover span {
    background: #0d6efd;
    width: 20px;
}

/* Responsive adjustments */
@media (max-width: 767px) {
    .team-card {
        margin: 5px 3px 15px;
    }
    
    .owl-nav button {
        width: 36px;
        height: 36px;
    }
    
    .owl-nav .owl-prev {
        left: -15px;
    }
    
    .owl-nav .owl-next {
        right: -15px;
    }
}
</style>

<script src="{{ asset('site/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(".team-carousel").owlCarousel({
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            smartSpeed: 1000,
            center: false,
            dots: true,
            loop: true,
            margin: 15,
            nav: true,
            navText: [
                '<i class="bi bi-arrow-left"></i>', 
                '<i class="bi bi-arrow-right"></i>'
            ],
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    margin: 10
                },
                576: {
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
    });
</script>