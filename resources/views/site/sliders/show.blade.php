<x-main-layout title="{{ $sliderData['title'] }}">

    <x-slot name="breadcrumbTitle">
        {{ $sliderData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Gallery</li>
    </x-slot>
    
    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            <p><strong>Published At:</strong> {{ $sliderData['published_at'] ? $sliderData['published_at']->format('M d, Y') : 'Not Published' }}</p>
            <p><strong>Views:</strong> {{ $sliderData['views_count'] }}</p>
        </div>
        <!-- Responsive Image -->
        <img 
            src="{{ $sliderData['image']['large'] }}" 
            srcset="{{ $sliderData['image']['medium'] }} 800w, {{ $sliderData['image']['large'] }} 1200w" 
            sizes="(max-width: 600px) 400px, (max-width: 1200px) 800px, 1200px" 
            class="img-fluid my-4" 
            alt="{{ $sliderData['title'] }}">


        <div class="description mt-4">
            <h2>Description</h2>
            <p>{!! nl2br($sliderData['description']) !!}</p>
        </div>
    </div>
</x-main-layout>
