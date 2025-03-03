@include('layouts.partials.admin.header')
<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="PORMS" app-url="{{ route('admin.apps.porms.index') }}">
    @can('view any porms')
    <li>
        <a href="{{ route('admin.apps.porms.index') }}"><i class="bi-person-vcard text-success"></i>&nbsp; Home</a>
    </li>
    @endcan

    @can('view any porms')
    <li>
        <a href="{{ route('admin.apps.porms.all') }}"><i class="bi-coin text-success"></i>&nbsp; Receipts</a>
    </li>
    @endcan

    @can('view porms report')
    <li>
        <a href="{{ route('admin.apps.porms.report') }}"><i class="bi-flag text-success"></i>&nbsp; Report</a>
    </li>
    @endcan
</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="$settings->site_name" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
