<x-main-layout title="Gallery">
    <!-- Breadcrumb Section -->
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-2" style="max-width: 900px;">
            <h3 class="text-white display-3 mb-4">Gallery</h3>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('site') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white">Gallery</li>
            </ol>
        </div>
    </div>

    <!-- Gallery Section -->
    <div class="container my-5">
        <div class="row">
            <!-- Left-Aligned Tabs for Each Gallery Type -->
            <div class="col-md-3">
                <ul class="nav nav-pills flex-column bg-light rounded p-3 shadow-sm" id="galleryTabs" role="tablist">
                    @foreach ($galleriesByType as $type => $galleries)
                        <li class="nav-item mb-2" role="presentation">
                            <a class="nav-link @if($loop->first) active @endif text-center p-2 fw-bold" 
                               id="tab-{{ Str::slug($type) }}" 
                               data-bs-toggle="tab" 
                               href="#{{ Str::slug($type) }}" 
                               role="tab" 
                               aria-controls="{{ Str::slug($type) }}" 
                               aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Right-Aligned Tab Content for Galleries -->
            <div class="col-md-9">
                <div class="tab-content" id="galleryTabContent">
                    @foreach ($galleriesByType as $type => $galleries)
                        <div class="tab-pane fade @if($loop->first) show active @endif" 
                             id="{{ Str::slug($type) }}" 
                             role="tabpanel" 
                             aria-labelledby="tab-{{ Str::slug($type) }}">

                            <!-- Gallery Heading -->
                            <h4 class="mt-3 mb-3 text-primary">{{ ucfirst(str_replace('_', ' ', $type)) }} Gallery</h4>

                            <!-- Gallery Images -->
                            <div class="row g-3">
                                @foreach ($galleries as $gallery)
                                    @foreach ($gallery->getMedia('gallery') as $media)
                                        <div class="col-md-4">
                                            <a href="{{ $media->getUrl() }}" data-bs-toggle="modal" data-bs-target="#lightboxModal-{{ $media->id }}">
                                                <img src="{{ $media->getUrl() }}" alt="{{ $gallery->title }}" class="img-fluid rounded shadow-sm" style="max-height: 200px; object-fit: cover;" />
                                            </a>

                                            <!-- Lightbox Modal -->
                                            <div class="modal modal-lg fade" id="lightboxModal-{{ $media->id }}" tabindex="-1" aria-labelledby="lightboxModalLabel-{{ $media->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content bg-transparent border-0">
                                                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        <img src="{{ $media->getUrl() }}" alt="{{ $gallery->title }}" class="img-fluid rounded">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
