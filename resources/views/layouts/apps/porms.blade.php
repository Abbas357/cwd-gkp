@include('layouts.partials.admin.header')
<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'PORMS' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="PORMS" app-url="{{ route('admin.apps.porms.index') }}">
    @can('viewAny', App\Models\ProvincialOwnReceipt::class)
    <li>
        <a href="{{ route('admin.apps.porms.index') }}">
            <div class="parent-icon"><i class="bi-person-vcard text-primary"></i></div>
            <div class="menu-title">Home</div>
        </a>
    </li>
    @endcan

    @can('viewAny', App\Models\ProvincialOwnReceipt::class)
    <li>
        <a href="{{ route('admin.apps.porms.all') }}">
            <div class="parent-icon"><i class="bi-coin text-info"></i></div>
            <div class="menu-title">Receipts</div>
        </a>
    </li>
    @endcan

    @can('viewReports', App\Models\ProvincialOwnReceipt::class)
    <li>
        <a href="{{ route('admin.apps.porms.report') }}">
            <div class="parent-icon"><i class="bi-flag text-success"></i></div>
            <div class="menu-title">Report</div>
        </a>
    </li>
    @endcan
</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="setting('site_name', 'main', config('app.name'))" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
