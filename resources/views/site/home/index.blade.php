<x-main-layout title="{{ $title }}">
    @push('style')
    <link href="{{ asset('site/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header"></x-slot>

    <div class="container-fluid position-relative p-0">
        @include('site.home.partials.slider')
    </div>

    <div class="container-fluid position-relative module" style="top: -50%; transform: translateY(-50%);">
        @include('site.home.partials.main-links')
    </div>
    
    <!-- Placeholder for Message Section -->
    <div id="message-section" class="container-fluid pb-3" style="min-height: 400px">
        <!-- Loading Spinner -->
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status" id="message-spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Placeholder for About Section -->
    <div id="about-section" class="container-fluid about py-3" style="min-height: 400px">
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status" id="about-spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Placeholder for Gallery Section -->
    <div id="gallery-section" style="min-height: 400px">
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status" id="gallery-spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Placeholder for Blogs Section -->
    <div id="blogs-section" style="min-height: 400px">
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status" id="blogs-spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Placeholder for Team Section -->
    <div id="team-section" class="container-fluid team py-3" style="min-height: 400px">
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status" id="team-spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Placeholder for Contact Section -->
    <div id="contact-section" class="container-fluid booking py-3" style="min-height: 400px">
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status" id="contact-spinner">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('site/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('site/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('site/lib/waypoints/waypoints.min.js') }}"></script>
    <script>
        function loadPartial(url, elementId, spinnerId) {
            $('#' + spinnerId).show();

            $.get(url, function(data) {
                $('#' + elementId).html(data);
            }).fail(function() {
                console.error('Error loading partial');
            }).always(function() {
                $('#' + spinnerId).hide();
            });
        }
    
        // Waypoint for Message Section
        new Waypoint({
            element: document.getElementById('message-section'),
            handler: function(direction) {
                loadPartial('{{ route('partials.message') }}', 'message-section', 'message-spinner');
                this.destroy(); // Destroy waypoint after content is loaded
            },
            offset: '100%'
        });

        // Waypoint for About Section
        new Waypoint({
            element: document.getElementById('about-section'),
            handler: function(direction) {
                loadPartial('{{ route('partials.about') }}', 'about-section', 'about-spinner');
                this.destroy();
            },
            offset: '100%'
        });

        // Waypoint for Gallery Section
        new Waypoint({
            element: document.getElementById('gallery-section'),
            handler: function(direction) {
                loadPartial('{{ route('partials.gallery') }}', 'gallery-section', 'gallery-spinner');
                this.destroy();
            },
            offset: '100%'
        });

        // Waypoint for Blogs Section
        new Waypoint({
            element: document.getElementById('blogs-section'),
            handler: function(direction) {
                loadPartial('{{ route('partials.blogs') }}', 'blogs-section', 'blogs-spinner');
                this.destroy();
            },
            offset: '100%'
        });

        // Waypoint for Team Section
        new Waypoint({
            element: document.getElementById('team-section'),
            handler: function(direction) {
                loadPartial('{{ route('partials.team') }}', 'team-section', 'team-spinner');
                this.destroy();
            },
            offset: '100%'
        });

        // Waypoint for Contact Section
        new Waypoint({
            element: document.getElementById('contact-section'),
            handler: function(direction) {
                loadPartial('{{ route('partials.contact') }}', 'contact-section', 'contact-spinner');
                this.destroy();
            },
            offset: '100%'
        });
    </script>
    @endpush
</x-main-layout>
