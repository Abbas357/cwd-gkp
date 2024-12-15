<x-main-layout title="{{ $title }}">
    @push('style')
    <link href="{{ asset('site/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('site/lib/newsticker/news-ticker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('site/css/dashboard.css') }}" rel="stylesheet">
    <style>
        
    </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div id="slider-section" class="container-fluid position-relative p-0 message-bg" style="min-height: 300px;">
        <!-- Loading Spinner -->
        <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
            <div class="spinner-border text-primary" role="status" id="slider-spinner" style="margin-top:5rem">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <div class="container-fluid position-relative module">
        @include('site.home.partials.main-links')
    </div>

    <div class="container position-relative" class="mb-4">
        @include('site.home.partials.newsticker')
    </div>
    
    <!-- Placeholder for Message Section -->
    <div id="message-section" class="container-fluid message-bg py-5" style="min-height: 400px">
        <!-- Loading Spinner -->
        <div class="container message pb-5">
            <div class="mx-auto text-center mb-5" style="max-width: 900px;">
                <h5 class="section-title px-3">Message</h5>
            </div>
            <div id="content"></div>
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status" id="message-spinner">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Placeholder for About Section -->
    <div id="about-section" class="container-fluid about about-bg py-3" style="min-height: 400px">
        <div class="container py-2">
            <div class="mx-auto text-center mb-5" style="max-width: 900px;">
                <h5 class="section-title px-3">About US</h5>
            </div>
            <div id="content"></div>
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status" id="about-spinner">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Placeholder for Gallery Section -->
    <div id="gallery-section" style="min-height: 400px; background: #f5f5f5">
        <div class="container gallery py-3">
            <div class="mx-auto text-center my-5" style="max-width: 900px;">
                <h5 class="section-title px-3">Our Gallery</h5>
            </div>
            <div id="content"></div>
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status" id="gallery-spinner">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Placeholder for Blogs Section -->
    <div id="events-section" style="min-height: 400px">
        <div class="container-fluid events py-5">
            <div class="container py-5">
                <div class="mx-auto text-center mb-5" style="max-width: 900px;">
                    <h5 class="section-title px-3">Events</h5>
                </div>
                <div id="content"></div>
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary" role="status" id="events-spinner">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Placeholder for Blogs Section -->
    <div id="blogs-section" style="min-height: 400px; background: #f5f5f5"">
        <div class="container-fluid blog py-3">
            <div class="container py-2">
                <div class="mx-auto text-center" style="max-width: 900px;">
                    <h5 class="section-title px-3 my-5">News</h5>
                </div>
                <div id="content"></div>
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary" role="status" id="blogs-spinner">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Placeholder for Team Section -->
    <div id="team-section" class="container-fluid team py-3" style="min-height: 400px">
        <div class="container py-2">
            <div class="mx-auto text-center" style="max-width: 900px;">
                <h5 class="section-title my-5 px-3">Meet Our Team</h5>
            </div>
            <div id="content"></div>
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status" id="team-spinner">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Placeholder for Contact Section -->
    <div id="contact-section" class="container-fluid contact-bg py-3" style="min-height: 400px">
        <div id="content"></div>
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
    <script src="{{ asset('site/lib/newsticker/news-ticker.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            loadSlider('{{ route('partials.slider') }}', 'slider-section', 'slider-spinner');
        });

        function loadSlider(url, elementId, spinnerId) {
            const spinner = document.getElementById(spinnerId);
            const element = document.getElementById(elementId);

            if (spinner) spinner.style.display = 'block';

            fetch(url)
                .then(response => response.text())
                .then(html => {
                    element.innerHTML = html; // Replace the content with the fetched HTML
                })
                .catch(error => {
                    console.error('Error loading slider:', error);
                    element.innerHTML = '<div class="text-center text-danger">Failed to load slider content.</div>';
                })
                .finally(() => {
                    if (spinner) spinner.style.display = 'none';
                });
        }

        function loadNews() {
            $.ajax({
                url: "{{ route('notifications.get') }}",
                method: 'GET',
                success: function(data) {
                    const {
                        announcement
                        , notifications
                    } = data;
                    displayNews(notifications);
                },
                error: function() {
                    console.log("Error fetching news.");
                }
            });
        }

        function displayNews(newsItems) {
            let tickerContent = newsItems.map((item, index) => 
                `<li><a href="${item.url}" target="_blank"><span class="fw-bold">${index + 1}.</span> &nbsp; ${item.title}</a></li>`
            ).join('');

            $('#newsTicker .bn-news ul').html(tickerContent);

            $('#newsTicker').breakingNews({
                effect: 'typography',
                themeColor: '#3b5998',
                fontSize: '20px'
            });
        }

        $(document).ready(function() {
            loadNews();
        });

        function loadPartial(url, elementId, spinnerId) {
            $('#' + spinnerId).show();

            $.get(url, function(data) {
                $('#' + elementId + ' #content').html(data);
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
                this.destroy();
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

        // Waypoint for Events Section
        new Waypoint({
            element: document.getElementById('events-section'),
            handler: function(direction) {
                loadPartial('{{ route('partials.events') }}', 'events-section', 'events-spinner');
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
