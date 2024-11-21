<x-main-layout title="{{ $newsData['title'] }}">

    <x-slot name="breadcrumbTitle">
        {{ $newsData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">News</li>
    </x-slot>
    
    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            @if (!empty($newsData['published_by']))
                <p><strong>Published By:</strong> {{ $newsData['published_by'] }}</p>
            @endif

            @if (!empty($newsData['published_at']))
                <p><strong>Published At:</strong> {{ $newsData['published_at'] }}</p>
            @endif
        </div>
        
        <div class="description mt-4">
            <h2>Description</h2>
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
                    
                    @elseif (str_contains($newsData['file_type'], 'pdf'))
                        <iframe src="{{ $newsData['file_url'] }}" style="width:100%; height:600px;" frameborder="0"></iframe>
                    
                    @else
                        <p>This file type is not directly viewable. Please <a href="{{ $newsData['file_url'] }}" target="_blank">download the attachment</a> to view.</p>
                    @endif
                </div>
            </div>
        @else
            <p>No attachment available.</p>
        @endif
    </div>
</x-main-layout>
