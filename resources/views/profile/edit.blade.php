<x-app-layout>
    <x-slot name="header">
        <li class="breadcrumb-item" aria-current="page">Profile</li>
    </x-slot>

    <div class="py-12">
        <div class="p-4 shadow">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 shadow">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</x-app-layout>
