<x-main-layout title="{{ $newsData['title'] }}">

    <x-slot name="breadcrumbTitle">
        {{ $newsData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">News</li>
    </x-slot>
    
    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            <p><strong>Published By:</strong> {{ $newsData['published_by'] }}</p>
            <p><strong>Published At:</strong> {{ $newsData['published_at'] }}</p>
        </div>
        
        <img 
            src="{{ $newsData['image'] }}"
            alt="{{ $newsData['title'] }}">
        <div class="description mt-4">
            <h2>Description</h2>
            <p>{!! nl2br($newsData['content']) !!}</p>
        </div>
    </div>
</x-main-layout>
