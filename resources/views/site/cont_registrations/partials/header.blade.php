<div class="top-nav-container">
    <div class="container d-flex justify-content-between align-items-center">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('registrations.dashboard') ? 'active' : '' }}" 
                   href="{{ route('registrations.dashboard') }}">
                    <i class="bi bi-house-door"></i> Home
                </a>
            </li>
            @if($contractor->status === 'new')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('registrations.edit') ? 'active' : '' }}" 
                   href="{{ route('registrations.edit') }}">
                    <i class="bi bi-pencil-square"></i> Edit Registration
                </a>
            </li>
            @endif
        </ul>
        <div class="d-flex justify-content-between align-items-center">
            <form action="{{ route('registrations.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
</div>