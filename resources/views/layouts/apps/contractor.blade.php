@include('layouts.partials.admin.header')
<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'Contractors' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="CONTRACTOR" app-url="{{ route('admin.apps.contractors.index') }}">
    @can('viewAny', App\Models\Contractor::class)
    <li>
        <a href="{{ route('admin.apps.contractors.index') }}">
            <div class="parent-icon">
                <i class="bi-person-vcard text-primary"></i>
            </div>
            <div class="menu-title">
                Contractor List
            </div>
        </a>
    </li>
    @endcan
    @can('viewAny', App\Models\ContractorRegistration::class)
    <li>
        <a href="{{ route('admin.apps.contractors.registration.index') }}">
            <div class="parent-icon">
                <i class="bi-list-check text-secondary"></i>
            </div>
            <div class="menu-title">
                Registrations
            </div>
        </a>
    </li>
    @endcan
</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="setting('site_name', 'main', config('app.name'))" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
