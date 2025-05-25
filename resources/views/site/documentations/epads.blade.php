<x-main-layout title="e-PADS Training">
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
    </style>
    @endpush

    <x-slot name="breadcrumbTitle">
        e-PADS Training
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">E-PADS Training</li>
    </x-slot>

    <div class="container my-5">
        <div class="row">
            <!-- Training Videos Section -->
            <div class="col-lg-6 mb-4">
                <div class="training-card card h-100">
                    <div class="card-body">
                        <h2 class="title">
                            <i class="bi bi-play-circle me-2"></i>
                            Training Videos
                        </h2>

                        <!-- General Video (Tutorial for Contractor Registration) -->
                        @if($videosByCategory->has('general_video'))
                            <div class="list-group-item" onclick="window.open('{{ $videosByCategory['general_video'][0]['url'] }}', '_blank')">
                                @foreach($videosByCategory['general_video'] as $video)
                                    <a href="{{ $video['url'] }}" target="_blank">
                                        <i class="bi bi-play-circle icon-video"></i>
                                        {{ $video['title'] }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        @foreach($categories as $category)
                            @if($videosByCategory->has($category['name']))
                                <div class="category-badge mt-4">
                                    <i class="{{ $category['icon'] }} me-2"></i>
                                    {{ $category['display_name'] }}
                                </div>
                                
                                <div class="list-group list-group-flush">
                                    @foreach($videosByCategory[$category['name']] as $video)
                                        <div class="list-group-item" onclick="window.open('{{ $video['url'] }}', '_blank')">
                                            <a href="{{ $video['url'] }}" target="_blank">
                                                @if(str_contains($video['url'], 'youtube.com'))
                                                    <i class="bi bi-youtube icon-video"></i>
                                                @else
                                                    <i class="bi bi-play-circle icon-video"></i>
                                                @endif
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

            <!-- Training Manuals Section -->
            <div class="col-lg-6 mb-4">
                <div class="training-card card h-100">
                    <div class="card-body">
                        <h2 class="title">
                            <i class="bi bi-book me-2"></i>
                            Training Manuals
                        </h2>
                        
                        <div class="list-group list-group-flush">
                            @foreach($trainingManuals as $manual)
                                <div class="list-group-item" onclick="window.open('{{ $manual['url'] }}', '_blank')">
                                    <a href="{{ $manual['url'] }}" target="_blank">
                                        <i class="bi bi-file-earmark-pdf icon-pdf"></i>
                                        {{ $manual['title'] }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>