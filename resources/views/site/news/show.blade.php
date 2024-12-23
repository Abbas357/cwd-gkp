<x-main-layout title="{{ $newsData['title'] }}">

    <x-slot name="breadcrumbTitle">
        {{ $newsData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">News</li>
    </x-slot>
    
    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            @if (!empty($newsData['published_at']))
                <p><strong>Published At:</strong> {{ $newsData['published_at'] }}</p>
            @endif
            <p><strong>Views:</strong> {{ $newsData['views_count'] }}</p>
        </div>
        
        <div class="description mt-4">
            <p>{!! nl2br($newsData['content'] ?? 'No content available.') !!}</p>
        </div>

        @if (!empty($newsData['file_url']))
            <div class="attachment mt-4">
                <h3>Attachment</h3>
                <a href="{{ $newsData['file_url'] }}" target="_blank">
                    Download ({{ strtoupper(pathinfo($newsData['file_url'], PATHINFO_EXTENSION)) }})
                </a>
                
                <div class="mt-2">
                    @if (str_starts_with($newsData['file_type'], 'image'))
                        <img src="{{ $newsData['file_url'] }}" alt="{{ $newsData['title'] }}" style="max-width:100%; height:auto;">
                    @else
                        <a href="{{ $newsData['file_url'] }}">Attachment</a>                    
                    @endif
                </div>
            </div>
        @else
            <p>No attachment available.</p>
        @endif
    </div>
</x-main-layout>
