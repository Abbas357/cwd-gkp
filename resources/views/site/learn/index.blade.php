<x-main-layout title="Training Tutorials">
    @push('style')
    <style>
        .title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .training-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }
        .training-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        .list-group-item {
            border: none;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
            border-radius: 8px !important;
            margin-bottom: 0.5rem;
            background: #f8f9fa;
            cursor: pointer;
        }
        .list-group-item:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateX(10px);
        }
        .list-group-item a {
            text-decoration: none;
            color: inherit;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        .list-group-item:hover a {
            color: white;
        }
        .icon-video {
            color: #e74c3c;
            margin-right: 12px;
            font-size: 1.2rem;
        }
        .icon-pdf {
            color: #e67e22;
            margin-right: 12px;
            font-size: 1.2rem;
        }
        .category-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: inline-block;
        }
        .section-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border-radius: 12px 12px 0 0;
            margin: 0;
        }
        .video-modal .modal-dialog {
            max-width: 90vw;
        }
        .video-modal .modal-body {
            padding: 0;
        }
        .video-modal iframe {
            width: 100%;
            height: 60vh;
            border: none;
        }
    </style>
    @endpush

    <x-slot name="breadcrumbTitle">
        Training Tutorials
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Training Tutorials</li>
    </x-slot>

    <div class="container my-5">
        @php
            // Group tutorials by type
            $videoTutorials = $videos->where('type', 'video');
            $pdfTutorials = $videos->where('type', 'pdf');
            
            function getTutorialIcon($tutorial) {
                if ($tutorial['type'] === 'pdf') {
                    return 'bi bi-file-earmark-pdf icon-pdf';
                } elseif ($tutorial['type'] === 'video') {
                    if (str_contains($tutorial['url'], 'youtube.com') || str_contains($tutorial['url'], 'youtu.be')) {
                        return 'bi bi-youtube icon-video';
                    } else {
                        return 'bi bi-play-circle icon-video';
                    }
                }
                return 'bi bi-file-earmark icon-pdf';
            }
            
            function getEmbedUrl($url) {
                if (str_contains($url, 'youtube.com/watch?v=')) {
                    $videoId = substr($url, strpos($url, 'v=') + 2);
                    if (strpos($videoId, '&') !== false) {
                        $videoId = substr($videoId, 0, strpos($videoId, '&'));
                    }
                    return "https://www.youtube.com/embed/{$videoId}?autoplay=1&rel=0";
                } elseif (str_contains($url, 'youtu.be/')) {
                    $videoId = substr($url, strrpos($url, '/') + 1);
                    if (strpos($videoId, '?') !== false) {
                        $videoId = substr($videoId, 0, strpos($videoId, '?'));
                    }
                    return "https://www.youtube.com/embed/{$videoId}?autoplay=1&rel=0";
                }
                return $url;
            }
            
            function formatCategoryName($category) {
                return ucwords(str_replace('_', ' ', $category));
            }
            
            function isCategoryEmpty($category) {
                return is_null($category) || $category === false || $category === '';
            }
        @endphp

        <div class="row">
            @if($videoTutorials->count() > 0)
            <div class="col-lg-6 mb-4">
                <div class="training-card card h-100">
                    <div class="section-header">
                        <h2 class="title mb-0">
                            <i class="bi bi-play-circle me-2"></i>
                            Video Tutorials
                        </h2>
                    </div>
                    <div class="card-body">
                        @php
                            $videosByCategory = $videoTutorials->groupBy('category');
                        @endphp

                        @foreach($videosByCategory as $category => $categoryVideos)
                            @if(isCategoryEmpty($category))
                                {{-- Uncategorized Videos --}}
                                <div class="list-group list-group-flush mb-4">
                                    @foreach($categoryVideos as $video)
                                        <div class="list-group-item" onclick="window.open('{{ $video['url'] }}', '_blank')">
                                            <a href="{{ $video['url'] }}" target="_blank">
                                                <i class="{{ getTutorialIcon($video) }}"></i>
                                                {{ $video['title'] }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="category-badge">
                                    <i class="bi bi-collection me-2"></i>
                                    {{ formatCategoryName($category) }}
                                </div>
                                
                                <div class="list-group list-group-flush mb-4">
                                    @foreach($categoryVideos as $video)
                                        <div class="list-group-item">
                                            <a href="{{ $video['url'] }}" target="_blank">
                                                <i class="{{ getTutorialIcon($video) }}"></i>
                                                {{ $video['title'] }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            @if($pdfTutorials->count() > 0)
            <div class="col-lg-6 mb-4">
                <div class="training-card card h-100">
                    <div class="section-header">
                        <h2 class="title mb-0">
                            <i class="bi bi-book me-2"></i>
                            Textual Tutorials
                        </h2>
                    </div>
                    <div class="card-body">
                        @php
                            $pdfsByCategory = $pdfTutorials->groupBy('category');
                        @endphp

                        @foreach($pdfsByCategory as $category => $categoryPdfs)
                            @if(isCategoryEmpty($category))
                                {{-- Uncategorized PDFs --}}
                                <div class="list-group list-group-flush mb-4">
                                    @foreach($categoryPdfs as $pdf)
                                        <div class="list-group-item" onclick="window.open('{{ $pdf['url'] }}', '_blank')">
                                            <a href="{{ $pdf['url'] }}" target="_blank">
                                                <i class="{{ getTutorialIcon($pdf) }}"></i>
                                                {{ $pdf['title'] }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="category-badge">
                                    <i class="bi bi-collection me-2"></i>
                                    {{ formatCategoryName($category) }}
                                </div>
                                
                                <div class="list-group list-group-flush mb-4">
                                    @foreach($categoryPdfs as $pdf)
                                        <div class="list-group-item" onclick="window.open('{{ $pdf['url'] }}', '_blank')">
                                            <a href="{{ $pdf['url'] }}" target="_blank">
                                                <i class="{{ getTutorialIcon($pdf) }}"></i>
                                                {{ $pdf['title'] }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- No Tutorials Message -->
        @if($videos->count() == 0)
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i>
                    No tutorials available at the moment.
                </div>
            </div>
        @endif
    </div>
</x-main-layout>