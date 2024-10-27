<x-main-layout title="{{ $newsData['title'] }}">
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-2" style="max-width: 900px;">
            <h3 class="text-white display-3 mb-4">{{ $newsData['title'] }}</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('site') }}">Home</a></li>
                <li class="breadcrumb-item active text-white">News</li>
            </ol>    
        </div>
    </div>
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
