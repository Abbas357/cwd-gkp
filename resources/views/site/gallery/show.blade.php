<x-main-layout title="{{ $galleryData['title'] }}">
    @push('style')
        <link rel="stylesheet" href="{{ asset('site/lib/lightbox/lightbox.min.css') }}" />
    @endpush

    <x-slot name="breadcrumbTitle">
        {{ $galleryData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('gallery.index') }}">Gallery</a></li>
    </x-slot>

    <div class="container py-3">
        <div class="gallery-detail">
            <div class="d-flex justify-content-between">
                @if(!empty($galleryData['published_at']))
                <p><strong>Published At:</strong> {{ $galleryData['published_at'] }}</p>
                @endif
                <p><strong>Views:</strong> {{ $galleryData['views_count'] }}</p>
            </div>
            
            @if(!empty($galleryData['images']))
                <div class="gallery-images row mt-4">
                    @foreach($galleryData['images'] as $image)
                        @if(!empty($image))
                            <div class="gallery-image-item col-md-3">
                                <a href="{{ $image }}" data-lightbox="gallery-images" data-title="{{ $galleryData['title'] }}">
                                    <img src="{{ $image }}" class="img-fluid rounded mb-3" alt="{{ $galleryData['title'] }}">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
            
            @if(!empty($galleryData['description']))
                <div class="description mt-4">
                    <h2>Description</h2>
                    <p>{!! nl2br($galleryData['description']) !!}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="container mt-4">
        <h5 class="sharer-title">Share this gallery</h5>
        @php
            $title = $galleryData['title'] . ' - ' . config('app.name');
        @endphp
        <div class="sharer-container">
            <div class="sharer-button" data-sharer="email" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-envelope-fill"></i>
                <span>Email</span>
            </div>
            <div class="sharer-button" data-sharer="whatsapp" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-whatsapp"></i>
                <span>WhatsApp</span>
            </div>
            <div class="sharer-button" data-sharer="facebook" data-url="{{ url()->current() }}">
                <i class="bi bi-facebook"></i>
                <span>Facebook</span>
            </div>
            <div class="sharer-button" data-sharer="twitter" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-twitter-x"></i>
                <span>X</span>
            </div>
            <div class="sharer-button" data-sharer="threads" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-threads"></i>
                <span>Threads</span>
            </div>
            <div class="sharer-button" data-sharer="linkedin" data-url="{{ url()->current() }}">
                <i class="bi bi-linkedin"></i>
                <span>LinkedIn</span>
            </div>
            <div class="sharer-button" data-sharer="telegram" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-telegram"></i>
                <span>Telegram</span>
            </div>
            <div class="sharer-button" data-sharer="reddit" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-reddit"></i>
                <span>Reddit</span>
            </div>
            <div class="sharer-button" data-sharer="pinterest" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-pinterest"></i>
                <span>Pinterest</span>
            </div>
        </div>
    </div>

    <x-sharer :title="$galleryData['title'].' - '.config('app.name')" :url="url()->current()" />
    <x-comments :comments="$galleryData['comments']" modelType="Gallery" :modelId="$galleryData['id']" />

    @push('script')
        <script src="{{ asset('site/lib/lightbox/lightbox.min.js') }}"></script>
        <script>
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'disableScrolling': true,
            });
        </script>

    @endpush
</x-main-layout>