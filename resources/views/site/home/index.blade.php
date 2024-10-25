<x-main-layout title="{{ $title }}">
    @push('style')
    <link href="{{ asset('site/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('site/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
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

    @include('site.home.partials.gallery')

    @include('site.home.partials.blogs')

    <div class="container-fluid team py-3">
        @include('site.home.partials.team')
    </div>

    <div class="container-fluid booking py-3">
        @include('site.home.partials.contact')
    </div>

    @push('script')
    <script src="{{ asset('site/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('site/lib/lightbox/js/lightbox.min.js') }}"></script>
    {{-- <script src="{{ asset('site/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('site/lib/waypoints/waypoints.min.js') }}"></script> --}}
    @endpush
</x-main-layout>
