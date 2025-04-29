@include('layouts.partials.admin.header')
<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="SETTINGS">
    @can('updateCore', App\Models\Setting::class)
    <li>
        <a href="{{ route('admin.settings.index') }}">
            <div class="parant-icon">
                <i class="bi-gear text-success"></i>
            </div>
            <div class="menu-title">Settings </div>
        </a>
    </li>
    @endcan

    @can('manageDistricts', App\Models\Setting::class)
    <li>
        <a href="{{ route('admin.districts.index') }}">
            <div class="parant-icon">
                <i class="bi-map text-primary"></i>
            </div>
            <div class="menu-title">Districts </div>
        </a>
    </li>
    @endcan

    @can('viewActivity', App\Models\Setting::class)
    <li>
        <a href="{{ route('admin.activity.index') }}">
            <div class="parant-icon">
                <i class="bi-clipboard-pulse text-warning"></i>
            </div>
            <div class="menu-title">Activity Log</div>
        </a>
    </li>
    @endcan

</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="setting('site_name', 'main', config('app.name'))" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
