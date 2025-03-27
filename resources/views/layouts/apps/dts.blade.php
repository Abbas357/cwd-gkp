@include('layouts.partials.admin.header')
<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'DTS' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="DTS" app-url="{{ route('admin.apps.dts.index') }}">
    @can('view any dts')
    <li>
        <a href="{{ route('admin.apps.dts.index') }}">
            <div class="parent-icon"><i class="bi-house-fill text-primary"></i></div>
            <div class="menu-title">Home</div>
        </a>
    </li>
    @endcan

    @can('view any infrastructures')
    <li>
        <a href="{{ route('admin.apps.dts.all') }}">
            <div class="parent-icon"><i class="bi-building text-info"></i></div>
            <div class="menu-title">Infrastructures</div>
        </a>
    </li>
    @endcan

    @can('view any damages')
    <li>
        <a href="{{ route('admin.apps.dts.all') }}">
            <div class="parent-icon"><i class="bi-exclamation-triangle text-warning"></i></div>
            <div class="menu-title">Damages</div>
        </a>
    </li>
    @endcan

    @can('view dts report')
    <li>
        <a href="{{ route('admin.apps.dts.report') }}">
            <div class="parent-icon"><i class="bi-flag text-success"></i></div>
            <div class="menu-title">Report</div>
        </a>
    </li>
    @endcan
</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="$settings->site_name" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
