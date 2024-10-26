<x-main-layout title="{{ $sliderData['title'] }}">
    <div class="container mt-3">
        <h1 class="mb-3">{{ $sliderData['title'] }}</h1>
        <div class="d-flex justify-content-between">
            <p><strong>Published By:</strong> {{ $sliderData['published_by'] }}</p>
            <p><strong>Published At:</strong> {{ $sliderData['published_at'] ? $sliderData['published_at']->format('M d, Y') : 'Not Published' }}</p>
        </div>
        <!-- Responsive Image -->
        <img 
            src="{{ $sliderData['image']['large'] }}" 
            srcset="{{ $sliderData['image']['small'] }} 400w, {{ $sliderData['image']['medium'] }} 800w, {{ $sliderData['image']['large'] }} 1200w" 
            sizes="(max-width: 600px) 400px, (max-width: 1200px) 800px, 1200px" 
            class="img-fluid my-4" 
            alt="{{ $sliderData['title'] }}">


        <div class="description mt-4">
            <h2>Description</h2>
            <p>{!! nl2br($sliderData['description']) !!}</p>
        </div>
    </div>
</x-main-layout>
