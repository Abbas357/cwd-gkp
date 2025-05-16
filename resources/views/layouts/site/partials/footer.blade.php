<style>

    .footer a {
        color: #ffffff;
        display: block;
        margin-bottom: 0.1rem;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .footer a:hover {
        color: #17a2b8;
        transform: translateX(5px);
    }
    
    .social-icons a:hover {
        transform: translateY(-3px);
    }
    
    @media (max-width: 600px) {
        .footer-title {
            cursor: pointer;
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .footer-title::after {
            content: '\f282';
            font-family: 'bootstrap-icons';
            position: absolute;
            right: 0;
            transition: transform 0.3s;
        }
        
        .footer-title.active::after {
            transform: rotate(180deg);
        }
        
        .footer-content {
            display: none;
            padding-left: 5px;
            margin-bottom: 5px;
        }
        
        .footer-content.active {
            display: block;
        }

        .footer .row>* {
            margin-top: 1.3rem;
        }
        
        .footer-item {
            margin-bottom: 0;
        }
    }
</style>

<img src="{{ asset('site/images/section-bg2.png') }}" style="height:100px;width:100%; opacity: 0.3; border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem; box-shadow: 0 0 1rem #00000011; border-top: 1px solid #ccc; margin-top:1rem" alt="CWD">

<div class="container-fluid footer py-2">
    <div class="container py-3">
        <div class="row g-5">
            <div class="mt-3"></div>
            <!-- About Us Section -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <h4 class="mb-2 text-white footer-title">About Us</h4>
                <div class="footer-content">
                    <p class="text-white">
                        {{ setting('description', 'main', 'Communication & Works Department, Government of Khyber Pakhtunkhwa.') }}
                    </p>
                </div>
            </div>
            
            <!-- Department Section -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-2 text-white footer-title">Department</h4>
                    <div class="footer-content">
                        <a href="{{ route('pages.show', 'about') }}"><i class="bi bi-arrow-right-short me-2"></i> About</a>
                        <a href="{{ route('pages.show', 'introduction') }}"><i class="bi bi-arrow-right-short me-2"></i> Introduction</a>
                        <a href="{{ route('pages.show', 'vision') }}"><i class="bi bi-arrow-right-short me-2"></i> Vision</a>
                        <a href="{{ route('pages.show', 'functions') }}"><i class="bi bi-arrow-right-short me-2"></i> Functions</a>
                        <a href="#"><i class="bi bi-arrow-right-short me-2"></i> Organogram</a>
                        <a href="#"><i class="bi bi-arrow-right-short me-2"></i> Sitemap</a>
                        <a href="#"><i class="bi bi-arrow-right-short me-2"></i> FAQ</a>
                    </div>
                </div>
            </div>
            
            <!-- Modules Section -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-2 text-white footer-title">Modules</h4>
                    <div class="footer-content">
                        <a href="{{ route('contractors.login.get') }}"><i class="bi bi-arrow-right-short me-2"></i> E-Registration</a>
                        <a href="{{ route('standardizations.login.get') }}"><i class="bi bi-arrow-right-short me-2"></i> E-Standardization</a>
                        <a href="http://eprocurement.cwd.gkp.pk"><i class="bi bi-arrow-right-short me-2"></i> E-bidding</a>
                        <a href="http://etenders.cwd.gkp.pk/"><i class="bi bi-arrow-right-short me-2"></i> Contractor Login</a>
                        <a href="http://103.240.220.71:8080/index.php"><i class="bi bi-arrow-right-short me-2"></i> GIS Portal</a>
                        <a href="http://175.107.63.223:8889/forms/frmservlet?config=mb"><i class="bi bi-arrow-right-short me-2"></i> E-Billing</a>
                        <a href="https://pr.cwd.gkp.pk"><i class="bi bi-arrow-right-short me-2"></i> PWMIS</a>
                        <a href="https://old.cwd.gkp.pk/etender/login.php"><i class="bi bi-arrow-right-short me-2"></i> Old E-Tender</a>
                        <a href="https://old.cwd.gkp.pk/etender/contlogin.php"><i class="bi bi-arrow-right-short me-2"></i> Tender Form (OLD SYSTEM)</a>
                    </div>
                </div>
            </div>
            
            <!-- Contact Section -->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-2 text-white footer-title">Get In Touch</h4>
                    <div class="footer-content">
                        <a href=""><i class="bi bi-house me-2"></i>{{ setting('contact_address', 'main', 'Civil Secretariat, Peshawar') }}</a>
                        <a href=""><i class="bi bi-envelope me-2"></i>{{ setting('email', 'main', 'info@cwd.gkp.pk') }}</a>
                        <a href=""><i class="bi bi-phone me-2"></i>{{ setting('contact_phone', 'main', '091-9214039') }}</a>
                    </div>
                </div>
                <div class="footer-item d-flex flex-column mt-4">
                    <h4 class="mb-2 text-white footer-title">Follow Us</h4>
                    <div class="footer-content">
                        <div class="social-icons">
                            <a href="https://facebook.com/{{ setting('facebook', 'main', 'CWDKPGovt') }}"><i class="bi bi-facebook fs-4 me-2"></i> Facebook</a>
                            <a href="https://twitter.com/{{ setting('twitter', 'main', 'CWDKPGovt') }}"><i class="bi bi-twitter-x fs-4 me-2"></i>X (Formally Twitter)</a>
                            <a href="https://youtube.com/{{ setting('youtube', 'main', 'CWDKPGovt') }}"><i class="bi bi-youtube fs-4 me-2"></i> YouTube</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid copyright text-body py-2">
    <div class="container">
        <div class="g-4 align-items-center">
            <div class="text-center mb-md-0 text-white">
                <a class="text-white" href="https://cwd.gkp.pk">&copy; {{ setting('site_name', 'main', config('app.name')) }}</a>
                <div>Developed and maintained by <a class="text-info" href="https://cwd.gkp.pk">IT Cell, C&W Department</a></div>
            </div>
        </div>
    </div>
</div>

<a href="#" class="btn btn-primary btn-primary-outline-0 btn-md-square back-to-top"><i class="bi bi-arrow-up"></i></a>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth <= 600) {
            const footerTitles = document.querySelectorAll('.footer-title');
            
            footerTitles.forEach(title => {
                title.addEventListener('click', function() {
                    this.classList.toggle('active');
                    const content = this.nextElementSibling;
                    if (content) {
                        content.classList.toggle('active');
                    }
                });
            });
        }
    });
</script>