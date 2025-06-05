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

</style>
@php
use App\Models\Standardization;
$standardizationId = session('standardization_id');
$standardization = Standardization::find($standardizationId);
$profilePictureUrl = $standardization?->getFirstMediaUrl('standardization_firms_pictures') ?: asset('site/images/default-dp.png');
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
                <a class="nav-link {{ request()->routeIs('standardizations.dashboard') ? 'active' : '' }}" href="{{ route('standardizations.dashboard') }}">
                    <i class="bi bi-house-door"></i> &nbsp; Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('standardizations.upload.get') ? 'active' : '' }}" href="{{ route('standardizations.upload.get') }}">
                    <i class="bi bi-file-earmark-plus"></i> &nbsp; Upload Documents
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('standardizations.product.*') ? 'active' : '' }}" href="#" id="productDropdown" role="button">
                    <i class="bi bi-clipboard-check"></i> &nbsp; Product
                </a>
                <ul class="dropdown-menu shadow" aria-labelledby="productDropdown">
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('standardizations.product.create') }}">
                            <i class="bi bi-pencil-square"></i> &nbsp; Add Product
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('standardizations.product.index') }}">
                            <i class="bi bi-list-check"></i> &nbsp; View Products
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="dropdown account-dropdown">
            <button class="btn dropdown-toggle py-1 d-flex align-items-center" type="button" id="dropdownMenuButton">
                <img src="{{ $profilePictureUrl }}" alt="Profile Picture" style="width:30px; height:30px; border-radius: 50px; outline: 2px solid #fff">
                <span> &nbsp; {{ $standardization->owner_name }}</span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <a class="dropdown-item" href="{{ route('standardizations.edit') }}">
                        <i class="bi-person"></i> &nbsp; Edit Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('standardizations.password.view') }}">
                        <i class="bi-key"></i> &nbsp; Change Password
                    </a>
                </li>
                <li>
                    <form action="{{ route('standardizations.logout') }}" method="POST" class="d-inline">
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
