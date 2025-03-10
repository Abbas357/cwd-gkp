@include('layouts.partials.admin.header')

<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'Vehicle MGT' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="VEHICLE MGT." app-url="{{ route('admin.apps.vehicles.index') }}">
    @can('view any vehicle')
    <li><a href="{{ route('admin.apps.vehicles.index') }}"><i class="bi-bus-front text-info"></i>&nbsp; Home</a></li>
    @endcan

    @can('view any vehicle')
    <li><a href="{{ route('admin.apps.vehicles.all') }}"><i class="bi-speedometer text-success"></i>&nbsp; Vehicles</a></li>
    @endcan

    @can('view any vehicle')
    <li><a href="{{ route('admin.apps.vehicles.reports') }}"><i class="bi-flag text-info"></i>&nbsp; Reports</a></li>
    @endcan
</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="$settings->site_name" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
