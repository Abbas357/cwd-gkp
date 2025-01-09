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
    }
    .form-label {
        font-weight: bold;
        color: #666;
    }
</style>
<div class="top-nav-container p-0 mt-1">
    <div class="container d-flex justify-content-between align-items-center">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('contractors.dashboard') ? 'active' : '' }}" 
                   href="{{ route('contractors.dashboard') }}">
                    <i class="bi bi-house-door"></i> &nbsp; Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('contractors.edit') ? 'active' : '' }}" 
                   href="{{ route('contractors.edit') }}">
                    <i class="bi-info-circle"></i> &nbsp; Basic Information
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('contractors.hr_profiles.create') ? 'active' : '' }}" 
                   href="{{ route('contractors.hr_profiles.create') }}">
                    <i class="bi-people"></i> &nbsp; Human Resource
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('contractors.machinery.create') ? 'active' : '' }}" 
                   href="{{ route('contractors.machinery.create') }}">
                    <i class="bi-gear"></i> &nbsp; Machinary
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('contractors.work_experience.create') ? 'active' : '' }}" 
                   href="{{ route('contractors.work_experience.create') }}">
                    <i class="bi-trophy"></i> &nbsp; Work Experience
                </a>
            </li>
        </ul>
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Account
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <a class="dropdown-item" href="{{ route('contractors.password.view') }}">
                        <i class="bi-key"></i> Change Password
                    </a>
                </li>
                <li>
                    <form action="{{ route('contractors.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>