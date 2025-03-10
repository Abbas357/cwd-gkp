@include('layouts.partials.admin.header')

<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'Standardization' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="STANDARDIZATION" app-url="{{ route('admin.apps.standardizations.index') }}">
    @can('view any standardization')
    <li><a href="{{ route('admin.apps.standardizations.index') }}"><i class="bi-patch-check-fill text-success"></i>&nbsp; Standardizations</a></li>
    @endcan

    @can('view any standardization')
    <li><a href="{{ route('standardizations.login.get') }}"><i class="bi-flag text-warning"></i>&nbsp; Reports</a></li>
    @endcan
</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="$settings->site_name" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
