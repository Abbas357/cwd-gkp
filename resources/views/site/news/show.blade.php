<x-main-layout title="{{ $newsData['title'] }}">

    @push('style')
    <style>
        #commentForm {
            margin: auto;
            margin-top: 1.5rem;
            border: 1px solid #ddd;
        }

        #commentForm .btn {
            background: linear-gradient(90deg, #007bff, #0056b3);
            border: none;
            color: #fff;
            font-weight: bold;
            padding: 10px 20px;
            text-transform: uppercase;
            transition: background 0.3s ease;
        }

        #commentForm .btn:hover {
            background: linear-gradient(90deg, #0056b3, #007bff);
        }

        #commentForm {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #commentForm input::placeholder,
        #commentForm textarea::placeholder {
            font-style: italic;
            color: #6c757d;
        }
    </style>
    @endpush

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
                @endif
            </div>
        </div>
        @else
        <p>No attachment available.</p>
        @endif
 
        <x-sharer :title="$newsData['title'].' - '.config('app.name')" :url="url()->current()" />
        <x-comments :comments="$newsData['comments']" modelType="News" :modelId="$newsData['id']" />

    </div>
</x-main-layout>
