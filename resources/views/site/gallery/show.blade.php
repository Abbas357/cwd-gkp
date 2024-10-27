<x-main-layout title="{{ $galleryData['title'] }}">
    <div class="container py-3">
        <div class="gallery-detail">
            <h2>{{ $galleryData['title'] }}</h2>
            <p>{{ $galleryData['description'] }}</p>
            <small>
                Type: {{ $galleryData['type'] }} | Published on: {{ $galleryData['published_at'] }} | By: {{ $galleryData['user'] }}
            </small>
            <div class="gallery-images mt-4">
                @foreach($galleryData['images'] as $image)
                    <div class="gallery-image-item">
                        <a href="{{ $image }}" data-lightbox="gallery-images">
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
    
</x-main-layout>
