@include('layouts.partials.admin.header')
<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'Consultants' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="CONSULTANTS" app-url="{{ route('admin.apps.consultants.index') }}">
    @can('viewAny', App\Models\Consultant::class)
    <li>
        <a href="{{ route('admin.apps.consultants.index') }}">
            <div class="parent-icon">
                <i class="bi-person-vcard text-primary"></i>
            </div>
            <div class="menu-title">
                Consultants
            </div>
        </a>
    </li>
    @endcan
    @can('report', App\Models\Consultant::class)
    <li>
        <a href="{{ route('admin.apps.consultants.report') }}">
            <div class="parent-icon">
                <i class="bi-flag text-secondary"></i>
            </div>
            <div class="menu-title">
                Reports
            </div>
        </a>
    </li>
    @endcan
</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="setting('site_name', 'main', config('app.name'))" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
