<x-main-layout title="{{ $galleryData['title'] }}">
    @push('style')
        <link rel="stylesheet" href="{{ asset('admin/plugins/lightbox/lightbox.min.css') }}" />
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

    @push('script')
        <script src="{{ asset('admin/plugins/lightbox/lightbox.min.js') }}"></script>
        <script>
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'disableScrolling': true,
            });
        </script>
    @endpush
</x-main-layout>