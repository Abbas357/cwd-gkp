@include('layouts.partials.admin.header')
<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="SETTINGS">

    @can('view settings')
    <li>
        <a href="{{ route('admin.settings.index') }}"><i class="bi-gear text-success"></i>&nbsp; Settings</a>
    </li>
    @endcan

    @can('view any category')
    <li>
        <a href="{{ route('admin.categories.index') }}"><i class="bi-tags text-success"></i>&nbsp; Categories</a>
    </li>
    @endcan

    @can('view any district')
    <li>
        <a href="{{ route('admin.districts.index') }}"><i class="bi-map text-success"></i>&nbsp; Districts</a>
    </li>
    @endcan

    @can('view any district')
    <li>
        <a href="{{ route('admin.activity.index') }}"><i class="bi-clipboard-pulse text-success"></i>&nbsp; Activity Log</a>
    </li>
    @endcan

</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="$settings->site_name" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
