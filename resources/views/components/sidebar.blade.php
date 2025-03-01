<div id="{{ $componentId }}" class="sidebar-component">
    <aside class="sidebar-wrapper" style="{{ $bgColor ? 'background-color: '.$bgColor.';' : '' }} 
        {{ $bgImage ? 'background-image: url('.$bgImage.'); background-size: cover; background-position: center;' : '' }}
        {{ $textColor ? 'color: '.$textColor.';' : '' }}">
        <a href="{{ route('admin.apps') }}" class="sidebar-header d-flex align-items-center">
            <div class="logo-icon">
                <img src="{{ $logoUrl }}" style="width:40px; border-radius:5px" class="mt-2" alt="Logo Desktop">
            </div>
            <div class="logo-name flex-grow-1 mt-2">
                <h5 class="mb-0 fs-6 fw-bold gradient-text" style="letter-spacing: .1px; transform: scale(1,1.4)">
                    {{ $appName }}
                </h5>
            </div>
            @if($collapsible)
            <div class="sidebar-close">
                <span class="bi-layout-sidebar"></span>
            </div>
            @endif
        </a>
        <div class="sidebar-nav" data-simplebar="true">
            <ul class="metismenu" id="sidenav">
                {{ $slot }}
            </ul>
        </div>
        <div class="sidebar-bottom gap-4">
            @if(isset($footer))
                {{ $footer }}
            @else
            <div class="dark-mode">
                <a href="javascript:;" class="footer-icon dark-mode-icon">
                    <i class="bi-moon"></i>
                </a>
            </div>
            <div class="dropdown dropup-center dropup dropdown-help">
                <form method="POST" action="{{ route('logout') }}" disabled>
                    @csrf
                    <a class="footer-icon dropdown-toggle dropdown-toggle-nocaret option" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.preventDefault();
                        this.closest('form').submit();
                        this.closest('.top-right-menu').classList.add('hidden')">
                        <i class="bi-power" style="font-size: var(--size-5)"></i>
                    </a>
                </form>
            </div>
            <div class="dropdown dropup-center dropup dropdown-help">
                <a class="footer-icon  dropdown-toggle dropdown-toggle-nocaret option" href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi-sliders"></i>
                </a>
                <div class="dropdown-menu dropdown-option dropdown-menu-end shadow">
                    @can('view activity')
                        <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.activity.index') }}"><i class="bi-activity"></i>Activity Log</a></div>
                    @endcan
                    @can('view settings')
                        <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.settings.index') }}"><i class="bi-gear"></i>Settings</a></div>
                    @endcan
                    <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.profile.edit') }}"><i class="bi-person-circle"></i>Edit Profile</a></div>
                </div>
            </div>
            @endif
        </div>
    </aside>

    <style>
        #{{ $componentId }} .sidebar-wrapper {
            background-color: {{ $darkMode ? '#212529' : '#ffffff' }};
            border-right: 1px solid {{ $darkMode ? '#373b3e' : '#e9ecef' }};
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            color: {{ $darkMode ? '#f8f9fa' : '#212529' }};
        }
     </style>
</div>