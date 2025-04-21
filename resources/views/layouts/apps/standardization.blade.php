@include('layouts.partials.admin.header')

<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'Standardization' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="STANDARDIZATION" app-url="{{ route('admin.apps.standardizations.index') }}">
    @can('viewAny', App\Models\Standardization::class)
    <li>
        <a href="{{ route('admin.apps.standardizations.index') }}">
            <div class="parent-icon"><i class="bi-patch-check-fill text-success"></i></div>
            <div class="menu-title">Standardizations</div>
        </a>
    </li>
    @endcan

    @can('viewAny', App\Models\Standardization::class)
    <li>
        <a href="{{ route('admin.apps.standardizations.index') }}#reports">
            <div class="parent-icon"><i class="bi-flag text-warning"></i></div>
            <div class="menu-title">Reports</div>
        </a>
    </li>
    @endcan
</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="setting('site_name', 'main', config('app.name'))" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
