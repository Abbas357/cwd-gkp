<x-main-layout title="{{ $achievementData['title'] }}">
    @push('style')
    <link rel="stylesheet" href="{{ asset('site/lib/lightbox/lightbox.min.css') }}" />
    <style>
        .gallery-item {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
    
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.15);
        }
    
        .hover-zoom {
            transition: transform 0.3s ease;
        }
    
        .gallery-item:hover .hover-zoom {
            transform: scale(1.05);
        }
    
        .gallery-hover-overlay {
            opacity: 0;
            background: rgba(0,0,0,0.3);
            transition: opacity 0.3s ease;
        }
    
        .gallery-item:hover .gallery-hover-overlay {
            opacity: 1;
        }
    
        .object-fit-cover {
            object-fit: cover;
            object-position: center;
        }
    </style>
    @endpush

    <x-slot name="breadcrumbTitle">
        {{ $achievementData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('achievements.index') }}">Achievements</a></li>
    </x-slot>

    <div class="container mt-3">
        <!-- Publisher Info -->
        <div class="d-flex justify-content-between">
            <p><strong>Published At:</strong> {{ $achievementData['published_at'] }}</p>
            <p><strong>Views:</strong> {{ $achievementData['views_count'] }}</p>
        </div>
        <!-- Achievement Details Table -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered">
                <tbody>
                    @if(!empty($achievementData['location']))
                    <tr>
                        <th>Location</th>
                        <td>{{ $achievementData['location'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($achievementData['start_date']))
                    <tr>
                        <th>Start Date</th>
                        <td>{{ $achievementData['start_date'] }}</td>
                    </tr>
                    @endif

                    @if(!empty($achievementData['end_date']))
                    <tr>
                        <th>End Date</th>
                        <td>{{ $achievementData['end_date'] }}</td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>

        @if(!empty($achievementData['content']))
        <tr class="content mt-4">
            <h2>Detail</h2>
            <p>{!! nl2br($achievementData['content']) !!}</p>
        </tr>
        @endif

        <div class="gallery-container mt-5">
            <h2 class="mb-4 fw-bold text-primary">Achievements Gallery</h2>
            <div class="row g-4">
                @foreach($achievementData['attachments'] as $file)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="gallery-item position-relative overflow-hidden rounded-3 shadow-sm">
                        <a href="{{ $file }}" data-lightbox="Achievement-images" data-title="{{ $achievementData['title'] }}" class="d-block">
                            <div class="ratio ratio-16x9">
                                <img src="{{ $file }}" 
                                     class="img-fluid object-fit-cover hover-zoom"
                                     alt="{{ $achievementData['title'] }}">
                            </div>
                            <div class="gallery-hover-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                <span class="text-white fs-4 bg-dark bg-opacity-50 rounded-pill px-3 py-1">
                                    <i class="bi bi-search"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
    </div>

    <x-sharer :title="$achievementData['title'].' - '.config('app.name')" :url="url()->current()" />

    @push('script')
    <script src="{{ asset('site/lib/lightbox/lightbox.min.js') }}"></script>
    <script>
        lightbox.option({
            'resizeDuration': 200
            , 'wrapAround': true
            , 'disableScrolling': true
        , });
    </script>
    @endpush
</x-main-layout>
