@include('layouts.partials.admin.header')

<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'ServiceCard' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="SERVICE CARD" app-url="{{ route('admin.apps.service_cards.index') }}">
    @can('view any service card')
    <li>
        <a href="{{ route('admin.apps.service_cards.index') }}">
            <div class="parent-icon"><i class="bi-credit-card text-success"></i></div>
            <div class="menu-title">Cards</div>
        </a>
    </li>
    @endcan

    @can('view service card report')
    <li>
        <a href="{{ route('service_cards.create') }}">
            <div class="parent-icon"><i class="bi-flag text-info"></i></div>
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
