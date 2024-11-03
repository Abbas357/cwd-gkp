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
        
        <div class="description mt-4">
            <h2>Description</h2>
            <p>{!! nl2br($newsData['content']) !!}</p>
        </div>

        {{-- Attachment at the end of the document --}}
        <div class="attachment mt-4">
            <h3>Attachment</h3>
            
            @if ($newsData['file_url'])
                <a href="{{ $newsData['file_url'] }}" target="_blank">
                    Download ({{ strtoupper(pathinfo($newsData['file_url'], PATHINFO_EXTENSION)) }})
                </a>
                
                {{-- Display content based on file type --}}
                <div class="mt-2">
                    {{-- If the file is an image --}}
                    @if (str_starts_with($newsData['file_type'], 'image'))
                        <img src="{{ $newsData['file_url'] }}" alt="{{ $newsData['title'] }}" style="max-width:100%; height:auto;">
                    
                    {{-- If the file is a PDF --}}
                    @elseif (str_contains($newsData['file_type'], 'pdf'))
                        

                    {{-- For other file types, provide download link only --}}
                    @else
                        <p>This file type is not directly viewable. Please <a href="{{ $newsData['file_url'] }}" target="_blank">download the attachment</a> to view.</p>
                    @endif
                </div>
            @else
                <p>No attachment available.</p>
            @endif
        </div>
    </div>
</x-main-layout>
