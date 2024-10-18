<x-main-layout>
    
    @push('style')
    @endpush
    <x-slot name="header"></x-slot>
    
    <div class="container-fluid position-relative p-0">
        @include('site.home.partials.slider')
    </div>

    <div class="container-fluid position-relative module" style="top: -50%; transform: translateY(-50%);">
        @include('site.home.partials.main-links')
    </div>
    
    <div class="container-fluid about py-3">
        @include('site.home.partials.about')
    </div>
    
    <div class="container-fluid bg-light service py-3">
        @include('site.home.partials.services')
    </div>
    
    <div class="container-fluid packages py-3">
        @include('site.home.partials.events')
    </div>
    
    @include('site.home.partials.gallery')
    
    @include('site.home.partials.blogs')
    
    <div class="container-fluid team py-3">
        @include('site.home.partials.team')
    </div>
    
    <div class="container-fluid booking py-3">
        @include('site.home.partials.contact')
    </div>

</x-main-layout>
