<style>
    .nav-tabs .nav-link {
        color: #495057;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
        font-weight: 600;
    }

    .top-nav-container {
        background: #f8f9fa;
        padding: 1rem;
        margin-bottom: 1rem;
        position: relative;
    }

    .form-label {
        font-weight: bold;
        color: #666;
    }

    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
    }

    .hamburger {
        display: none;
        background: none;
        border: none;
        padding: 10px;
        cursor: pointer;
    }

    .hamburger-line {
        display: block;
        width: 25px;
        height: 3px;
        margin: 5px 0;
        background-color: #495057;
        transition: all 0.3s ease;
    }

    .step-indicator {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 20px;
        display: inline-block;
        animation: pulser 2s infinite;
    }

    @keyframes pulser {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    .subtitle {
        color: #718096;
        font-size: 1.1rem;
        margin-bottom: 30px;
    }

    @media (max-width: 991px) {
        .hamburger {
            display: block;
            position: absolute;
            right: 15px;
            top: 15px;
            z-index: 1001;
        }

        .hamburger.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        .container {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .nav-tabs {
            display: none;
            width: 100%;
            padding: 10px 0;
        }

        .nav-tabs.show {
            display: block;
        }

        .nav-tabs .nav-item {
            width: 100%;
            margin: 5px 0;
        }

        .nav-tabs .nav-link {
            width: 100%;
            padding: 10px;
            border: none;
        }

        .dropdown-menu {
            position: static !important;
            width: 100%;
            margin-left: 20px;
            border: none;
            box-shadow: none;
            background: transparent;
        }

        .account-dropdown {
            width: 100%;
            margin-top: 10px;
        }

        .dropdown-menu.show {
            display: block;
        }
    }

    .dropdown-menu {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(20px) !important;
        border: 1px solid rgba(13, 110, 253, 0.2) !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
        animation: dropdownSlide 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) !important;
        overflow: hidden !important;
    }

    @keyframes dropdownSlide {
        0% {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .dropdown-item {
        transition: all 0.3s ease !important;
        border-radius: 8px !important;
        margin: 2px 8px !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .dropdown-item::before {
        content: '' !important;
        position: absolute !important;
        top: 0 !important;
        left: -100% !important;
        width: 100% !important;
        height: 100% !important;
        background: linear-gradient(90deg, transparent, rgba(13, 110, 253, 0.1), transparent) !important;
        transition: left 0.6s ease !important;
    }

    .dropdown-item:hover::before {
        left: 100% !important;
    }

    .dropdown-item:hover {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.1), rgba(13, 110, 253, 0.05)) !important;
        color: #0d6efd !important;
        transform: translateX(5px) !important;
        box-shadow: 0 2px 10px rgba(13, 110, 253, 0.2) !important;
    }

    .dropdown-item i {
        transition: transform 0.3s ease !important;
    }

    .dropdown-item:hover i {
        transform: scale(1.2) !important;
    }

    /* Floating animation for nav items */
    .nav-item {
        animation: float 6s ease-in-out infinite;
    }

    .nav-item:nth-child(2) {
        animation-delay: -2s;
    }

    .nav-item:nth-child(3) {
        animation-delay: -4s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-3px);
        }
    }

    @media (max-width: 991px) {
        .hamburger {
            display: block;
            position: absolute;
            right: 15px;
            top: 15px;
            z-index: 1001;
        }

        .hamburger.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        .container {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .nav-tabs {
            display: none;
            width: 100%;
            padding: 10px 0;
            animation: mobileSlide 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        @keyframes mobileSlide {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-tabs.show {
            display: block;
        }

        .nav-tabs .nav-item {
            width: 100%;
            margin: 5px 0;
        }

        .nav-tabs .nav-link {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 12px;
        }

        .dropdown-menu {
            position: static !important;
            width: 100%;
            margin-left: 20px;
            border: none;
            box-shadow: none;
            background: transparent;
        }

        .account-dropdown {
            width: 100%;
            margin-top: 10px;
        }

        .dropdown-menu.show {
            display: block;
        }
    }

</style>
@php
use App\Models\Consultant;
$consultantId = session('consultant_id');
$consultant = Consultant::find($consultantId);
@endphp
<div class="top-nav-container p-0 mt-1">
    <button class="hamburger" id="hamburgerBtn">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
    </button>

    <div class="container d-flex justify-content-between align-items-center">
        <ul class="nav nav-tabs" id="mainNav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('consultants.dashboard') ? 'active' : '' }}" href="{{ route('consultants.dashboard') }}">
                    <i class="bi bi-house-door"></i> &nbsp; Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('consultants.hr.create') ? 'active' : '' }}" href="{{ route('consultants.hr.create') }}">
                    <i class="bi-people"></i> &nbsp; Human Resource
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('consultants.projects.create') ? 'active' : '' }}" href="{{ route('consultants.projects.create') }}">
                    <i class="bi-gear"></i> &nbsp; Projects
                </a>
            </li>
        </ul>
        <div class="dropdown account-dropdown">
            <button class="btn dropdown-toggle py-1 d-flex align-items-center" type="button" id="dropdownMenuButton">
                <img src="{{ asset('site/images/default-dp.png') }}" alt="Profile Picture" style="width:30px; height:30px; border-radius: 50px; outline: 2px solid #fff">
                <span> &nbsp; {{ $consultant?->name }}</span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <a class="dropdown-item" href="{{ route('consultants.edit') }}">
                        <i class="bi-person"></i> &nbsp; Edit Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('consultants.password.view') }}">
                        <i class="bi-key"></i> &nbsp; Change Password
                    </a>
                </li>
                <li>
                    <form action="{{ route('consultants.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item py-2">
                            <i class="bi-box-arrow-right"></i> &nbsp; Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.getElementById('hamburgerBtn');
        const mainNav = document.getElementById('mainNav');

        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            mainNav.classList.toggle('show');
        });

        const dropdownToggleButtons = document.querySelectorAll('.dropdown-toggle');

        dropdownToggleButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const dropdown = this.nextElementSibling;

                dropdownToggleButtons.forEach(otherButton => {
                    if (otherButton !== this) {
                        otherButton.nextElementSibling.classList.remove('show');
                    }
                });

                dropdown.classList.toggle('show');
            });
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
                    dropdown.classList.remove('show');
                });
            }
        });

        function handleResize() {
            if (window.innerWidth > 991) {
                mainNav.classList.remove('show');
                hamburger.classList.remove('active');
            }
        }

        window.addEventListener('resize', handleResize);
    });

</script>
