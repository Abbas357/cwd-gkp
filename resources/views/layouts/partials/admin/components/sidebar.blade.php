<div id="{{ $componentId }}" class="sidebar-component">
    <aside class="sidebar-wrapper" style="{{ $bgColor ? 'background-color: '.$bgColor.';' : '' }} 
        {{ $bgImage ? 'background-image: url('.$bgImage.'); background-size: cover; background-position: center;' : '' }}
        {{ $textColor ? 'color: '.$textColor.';' : '' }}">
        <div class="sidebar-header d-flex align-items-center">
            <a href="{{ route('admin.apps') }}" class="logo-icon">
                <img src="{{ $logoUrl }}" alt="Main Logo" class="mt-2">
            </a>

            
            <div class="sidebar-expanded-only">
                <span class="vertical-divider vertical-app-bar">|</span>
            </div>

            <a href="{{ $appUrl }}" class="logo-name flex-grow-1 mt-2">
                <h5 class="mb-0 fs-6 fw-bold gradient-text">
                    {{ $appName }}
                </h5>
            </a>

            @if($collapsible)
            <div class="sidebar-close">
                <span class="bi-layout-sidebar"></span>
            </div>
            @endif
        </div>

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
                    <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.settings.activity.index') }}"><i class="bi-activity"></i>Activity Log</a></div>
                    @endcan
                    @can('view settings')
                    <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.settings.core.index') }}"><i class="bi-gear"></i>Settings</a></div>
                    @endcan
                    <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.settings.profile.edit') }}"><i class="bi-person-circle"></i>Edit Profile</a></div>
                </div>
            </div>
            @endif
        </div>
    </aside>

    <style scoped>
        .vertical-divider {
            color: #aaaaaa;
            padding-top: 1px;
            font-size: 1.7rem;
            line-height: 1;
        }

        .logo-icon img {
            width: 40px;
            border-radius: 5px;
        }

        .logo-name h5 {
            letter-spacing: 0.1px;
            transform: scale(1, 1.4);
        }

    </style>
</div>
