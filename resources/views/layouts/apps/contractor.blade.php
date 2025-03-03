@include('layouts.partials.admin.header')
<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="CONTRACTOR" app-url="{{ route('admin.apps.contractors.index') }}">
    @can('view any contractor')
    <li>
        <a href="{{ route('admin.apps.contractors.index') }}"><i class="bi-person-vcard text-success"></i>&nbsp; Contractor List</a>
    </li>
    @endcan

    @can('view any contractor')
    <li>
        <a href="{{ route('admin.apps.contractors.registration.index') }}"><i class="bi-list-check text-success"></i>&nbsp; Registrations</a>
    </li>
    @endcan
</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="$settings->site_name" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
