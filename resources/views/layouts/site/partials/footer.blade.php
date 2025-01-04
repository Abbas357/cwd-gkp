<!-- Footer Start -->
<img src="{{ asset('site/images/section-bg2.png') }}" style="height:100px;width:100%; opacity: 0.3; border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem; box-shadow: 0 0 1rem #00000011; border-top: 1px solid #ccc; margin-top:1rem" alt="CWD">

<div class="container-fluid footer py-2">
    <div class="container py-3">
        <div class="row g-5">
            <div class="col-md-6 col-lg-6 col-xl-3">
                <h4 class="mb-4 text-white">About Us</h4>
                <p class="text-white">
                    {{ $settings->description ?? 'Communication & Works Department, Government of Khyber Pakhtunkhwa.'}}
                </p>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Department</h4>
                    <a href="{{ route('pages.show', 'about') }}"><i class="bi bi-arrow-right-short me-2"></i> About</a>
                    <a href="{{ route('pages.show', 'introduction') }}"><i class="bi bi-arrow-right-short me-2"></i> Introduction</a>
                    <a href="{{ route('pages.show', 'vision') }}"><i class="bi bi-arrow-right-short me-2"></i> Vision</a>
                    <a href="{{ route('pages.show', 'functions') }}"><i class="bi bi-arrow-right-short me-2"></i> Functions</a>
                    <a href="#"><i class="bi bi-arrow-right-short me-2"></i> Organogram</a>
                    <a href="#"><i class="bi bi-arrow-right-short me-2"></i> Sitemap</a>
                    <a href="#"><i class="bi bi-arrow-right-short me-2"></i> FAQ</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Modules</h4>
                    <a href="{{ route('registrations.create') }}"><i class="bi bi-arrow-right-short me-2"></i> E-Registration</a>
                    <a href="{{ route('standardizations.create') }}"><i class="bi bi-arrow-right-short me-2"></i> E-Standardization</a>
                    <a href="http://eprocurement.cwd.gkp.pk"><i class="bi bi-arrow-right-short me-2"></i> E-bidding</a>
                    <a href="http://etenders.cwd.gkp.pk/"><i class="bi bi-arrow-right-short me-2"></i> Contractor Login</a>
                    <a href="http://103.240.220.71:8080/index.php"><i class="bi bi-arrow-right-short me-2"></i> GIS Portal</a>
                    <a href="http://175.107.63.223:8889/forms/frmservlet?config=mb"><i class="bi bi-arrow-right-short me-2"></i> E-Billing</a>
                    <a href="https://pr.cwd.gkp.pk"><i class="bi bi-arrow-right-short me-2"></i> PWMIS</a>
                    <a href="https://old.cwd.gkp.pk/etender/login.php"><i class="bi bi-arrow-right-short me-2"></i> Old E-Tender</a>
                    <a href="https://old.cwd.gkp.pk/etender/contlogin.php"><i class="bi bi-arrow-right-short me-2"></i> Tender Form (OLD SYSTEM)</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Get In Touch</h4>
                    <a href=""><i class="bi bi-house me-2"></i>{{ $settings->contact_address ?? 'Civil Secretariat, Peshawar'}}</a>
                    <a href=""><i class="bi bi-envelope me-2"></i>{{ $settings->email ?? 'info@cwd.gkp.pk'}}</a>
                    <a href=""><i class="bi bi-phone me-2"></i>{{ $settings->contact_phone ?? '091-9214039'}}</a>
                </div>
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-2 text-white">Follow Us</h4>
                    <div>
                        <a href="https://facebook.com/{{ $settings->facebook ?? 'CWDKPGovt'}}"><i class="bi bi-facebook fs-4 me-2"></i></a>
                        <a href="https://twitter.com/{{ $settings->twitter ?? 'CWDKPGovt'}}"><i class="bi bi-twitter-x fs-4 me-2"></i></a>
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

<!-- Back to Top Start -->
<a href="#" class="btn btn-primary btn-primary-outline-0 btn-md-square back-to-top"><i class="bi bi-arrow-up"></i></a>
<!-- Back to Top End -->