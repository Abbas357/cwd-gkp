@include('layouts.partials.admin.header')

<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'SecureDocument' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="DOCUMENT" app-url="{{ route('admin.apps.documents.index') }}">
    @can('viewAny', App\Models\SecureDocument::class)
    <li>
        <a href="{{ route('admin.apps.documents.index') }}">
            <div class="parent-icon"><i class="bi-credit-card text-success"></i></div>
            <div class="menu-title">Documents</div>
        </a>
    </li>
    @endcan

    @can('viewAny', App\Models\SecureDocument::class)
    <li>
        <a href="{{ route('admin.apps.documents.index') }}#reports">
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
