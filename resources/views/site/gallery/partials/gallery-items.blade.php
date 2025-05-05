<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-primary fw-bold mb-0">
        <i class="bi bi-images me-2"></i>{{ ucfirst(str_replace('_', ' ', $type)) }}
    </h3>
    <div class="d-flex gap-2">
        <button class="btn btn-sm btn-outline-secondary view-toggle" data-view="grid">
            <i class="bi bi-grid-fill"></i>
        </button>
        <button class="btn btn-sm btn-outline-secondary view-toggle" data-view="list">
            <i class="bi bi-list-ul"></i>
        </button>                                            
    </div>
</div>

<div class="row g-4 gallery-container">
    @forelse ($galleries as $gallery)
        @if(!empty($gallery->title) || !empty($gallery->slug) || !empty($gallery->items))
            <div class="col-lg-4 col-md-6 gallery-item">
                <div class="card h-100 border-0 shadow-sm hover-card overflow-hidden">
                    <div class="position-relative gallery-image">
                        @if(!empty($gallery->slug))
                            <a href="{{ route('gallery.show', $gallery->slug) }}" class="d-block overflow-hidden" style="aspect-ratio: 3/2;">
                                <img src="{{ $gallery->getFirstMediaUrl('gallery_covers') ?? asset('admin/images/no-image.jpg') }}" 
                                     alt="{{ $gallery->title }}" 
                                     class="img-fluid w-100 h-100 object-fit-cover transition" />
                            </a>
                            <div onclick="window.location.href= '{{ route('gallery.show', $gallery->slug) }}'" class="gallery-overlay d-flex align-items-center justify-content-center">
                                <button class="btn btn-light rounded-circle shadow-sm">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-body p-4">
                        @if(!empty($gallery->title))
                            <h5 class="card-title fw-bold mb-2">{{ $gallery->title }}</h5>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            @if(!empty($gallery->items))
                                <span class="badge bg-light text-primary">
                                    <i class="bi bi-image me-1"></i> {{ $gallery->items }} items
                                </span>
                            @endif
                            
                            <span class="badge bg-light text-secondary">
                                <i class="bi bi-eye me-1"></i> {{ $gallery->views_count ?? 0 }}
                            </span>
                        </div>
                        
                        <!-- Button only visible in list view -->
                        <div class="mt-3 d-none list-view-btn">
                            <a href="{{ route('gallery.show', $gallery->slug) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-arrow-right me-1"></i> View Gallery
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <a href="{{ route('gallery.show', $gallery->slug) }}" class="btn btn-sm btn-primary w-100">
                            <i class="bi bi-arrow-right me-1"></i> View Gallery
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>No galleries found in this category.
            </div>
        </div>
    @endforelse
</div>