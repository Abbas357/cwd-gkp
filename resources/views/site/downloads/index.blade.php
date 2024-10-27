<x-main-layout title="All Downloads">
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-2" style="max-width: 900px;">
            <h3 class="text-white display-3 mb-4">Downloads</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('site') }}">Home</a></li>
                <li class="breadcrumb-item active text-white">Downloads</li>
            </ol>    
        </div>
    </div>
    <div class="container my-3">
        <div class="row">
            <div class="col-md-3">
                <!-- Left-aligned Tabs -->
                <ul class="nav nav-pills flex-column" id="categoryTabs" role="tablist">
                    @foreach ($downloadsByCategory as $category => $downloads)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link p-3 @if($loop->first) active @endif" 
                               id="tab-{{ Str::slug($category) }}" 
                               data-bs-toggle="tab" 
                               href="#{{ Str::slug($category) }}" 
                               role="tab" 
                               aria-controls="{{ Str::slug($category) }}" 
                               aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $category }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-9">
                <!-- Right-aligned Tab Content -->
                <div class="tab-content" id="categoryTabContent">
                    @foreach ($downloadsByCategory as $category => $downloads)
                        <div class="tab-pane fade @if($loop->first) show active @endif" 
                             id="{{ Str::slug($category) }}" 
                             role="tabpanel" 
                             aria-labelledby="tab-{{ Str::slug($category) }}">
                             
                            <h4>{{ $category }} Downloads</h4>
                            <ul class="list-group">
                                @forelse ($downloads as $download)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>{{ $loop->iteration }}</span>
                                        <span>{{ $download->file_name }}</span>
                                        <span class="badge bg-primary rounded-pill">{{ $download->file_type }}</span>
                                        @if ($media = $download->getFirstMediaUrl('downloads'))
                                        <a href="{{ $media }}" class="btn-animate"><i class="bi-cloud-arrow-down"></i> Download</a>
                                        @else
                                            <span class="text-muted">No file available</span>
                                        @endif
                                    </li>
                                @empty
                                    <li class="list-group-item">No downloads available in this category.</li>
                                @endforelse
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
