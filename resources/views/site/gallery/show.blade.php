<x-main-layout title="{{ $galleryData['title'] }}">
    @push('style')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" />
    @endpush
    <x-slot name="breadcrumbTitle">
        {{ $galleryData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Gallery</li>
    </x-slot>

    <div class="container py-3">
        <div class="gallery-detail">
            <div class="d-flex justify-content-between">
                <p><strong>Published By:</strong> {{ $galleryData['published_by'] }}</p>
                <p><strong>Published At:</strong> {{ $galleryData['published_at'] }}</p>
            </div>
            
            <div class="gallery-images row mt-4">
                @foreach($galleryData['images'] as $image)
                    <div class="gallery-image-item col-md-3">
                        <a href="{{ $image }}" data-lightbox="gallery-images" data-title="{{ $galleryData['title'] }}">
                            <img src="{{ $image }}" class="img-fluid rounded mb-3" alt="{{ $galleryData['title'] }}">
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div class="description mt-4">
                <h2>Description</h2>
                <p>{!! nl2br($galleryData['description']) !!}</p>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
        <script>
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'disableScrolling': true,
            });
        </script>
    @endpush
</x-main-layout>