<!-- Footer Start -->
<img src="{{ asset('site/img/footer-img.png') }}" style="width:100%; opacity: 0.3" alt="CWD">

<div class="container-fluid footer py-2">
    <div class="container py-3">
        <div class="row g-5">
            <div class="col-md-6 col-lg-6 col-xl-3">
                <h4 class="mb-4 text-white">About Us</h4>
                <p class="text-white">
                    {{ $settings->description ?? 'Communications & Works Department was established in 1979. Since establishment the Department is working to promote safe, sustainable, cost effective and environment friendly road infrastructure leading to socio-economic development.'}}    
                </p>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Company</h4>
                    <a href=""><i class="bi bi-arrow-right-short me-2"></i> About</a>
                    <a href=""><i class="bi bi-arrow-right-short me-2"></i> Careers</a>
                    <a href=""><i class="bi bi-arrow-right-short me-2"></i> Blog</a>
                    <a href=""><i class="bi bi-arrow-right-short me-2"></i> Press</a>
                    <a href=""><i class="bi bi-arrow-right-short me-2"></i> Gift Cards</a>
                    <a href=""><i class="bi bi-arrow-right-short me-2"></i> Magazine</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Support</h4>
                    <a href=""><i class="bi bi-arrow-right-short me-2"></i> Contact</a>
                    <a href=""><i class="bi bi-arrow-right-short me-2"></i> Legal Notice</a>
                    <a href=""><i class="bi bi-arrow-right-short me-2"></i> Privacy Policy</a>
                    <a href=""><i class="bi bi-arrow-right-short me-2"></i> Terms and Conditions</a>
                    <a href=""><i class="bi bi-arrow-right-short me-2"></i> Sitemap</a>
                    <a href=""><i class="bi bi-arrow-right-short me-2"></i> Cookie policy</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Get In Touch</h4>
                    <a href=""><i class="bi bi-house me-2"></i>{{ $settings->contact_address ?? 'Civil Secretariat, Peshawar'}}</a>
                    <a href=""><i class="bi bi-envelope me-2"></i>{{ $settings->email ?? 'info@cwd.gkp.pk'}}</a>
                    <a href=""><i class="bi bi-phone me-2"></i>{{ $settings->contact_phone ?? '091-9214039'}}</a>
                    <a href="" class="mb-3"><i class="bi bi-whatsapp me-2"></i> {{ $settings->whatsapp ?? '0313-0535333'}}</a>
                </div>
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-2 text-white">Follow Us</h4>
                    <div>
                        <a href="https://facebook.com/{{ $settings->facebook ?? 'CWDKPGovt'}}"><i class="bi bi-facebook fs-4 me-2"></i></a>
                        <a href="https://twitter.com/{{ $settings->twitter ?? 'CWDKPGovt'}}"><i class="bi bi-twitter fs-4 me-2"></i></a>
                        <a href="https://youtube.com/{{ $settings->youtube ?? 'CWDKPGovt'}}"><i class="bi bi-youtube fs-4 me-2"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright text-body py-2">
    <div class="container">
        <div class="g-4 align-items-center">
            <div class="text-center mb-md-0 text-white">
                <a class="text-white" href="https://cwd.gkp.pk">&copy; {{ $settings->site_name ?? config('app.name') }}</a>
                <div>Developed and maintained by <a class="text-info" href="https://cwd.gkp.pk">IT Cell, C&W Department</a></div>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->

<!-- Back to Top -->
<a href="#" class="btn btn-primary btn-primary-outline-0 btn-md-square back-to-top"><i class="bi bi-arrow-up"></i></a>