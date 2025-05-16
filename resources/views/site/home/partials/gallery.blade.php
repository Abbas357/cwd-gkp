<!-- Gallery Section with Improved Design -->
<div class="gallery-section py-5">
    <!-- Custom Tab Navigation -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <ul class="nav nav-pills gallery-filter d-flex flex-wrap justify-content-center mb-5 gap-2">
                    @foreach($galleriesByType as $type => $galleries)
                    @php
                    $formattedType = ucfirst(str_replace('_', ' ', $type));
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link px-4 py-2 {{ $loop->first ? 'active' : '' }}" 
                           data-bs-toggle="pill" href="#GalleryTab-{{ $type }}">
                            <span>{{ $formattedType }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Gallery Content -->
    <div class="container">
        <div class="tab-content">
            @foreach($galleriesByType as $type => $galleries)
            <div id="GalleryTab-{{ $type }}" class="tab-pane fade show {{ $loop->first ? 'active' : '' }}">
                <div class="row g-4">
                    @foreach($galleries as $gallery)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="gallery-card">
                            <div class="gallery-img-container">
                                <img src="{{ $gallery->getFirstMediaUrl('gallery_covers') ?? asset('admin/images/no-image.jpg') }}" 
                                     alt="{{ $gallery->title }}" 
                                     class="img-fluid w-100" />
                                <div class="gallery-overlay">
                                    <div class="overlay-content">
                                        <h5 class="gallery-title text-white mb-1">{{ $gallery->title }}</h5>
                                        <div class="gallery-meta mb-3">
                                            <span class="badge bg-light text-dark">
                                                <i class="bi bi-images me-1"></i>{{ $gallery->items }}
                                            </span>
                                        </div>
                                        <a href="{{ route('gallery.show', ['slug' => $gallery->slug]) }}" 
                                           class="btn btn-sm btn-light">
                                           View Gallery <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
/* Gallery Section Styling */
.gallery-section {
    background-color: #f8f9fa;
}

/* Navigation Pills Styling */
.gallery-filter .nav-link {
    border-radius: 30px;
    font-weight: 600;
    color: #495057;
    background-color: #fff;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.gallery-filter .nav-link:hover {
    color: #0d6efd;
    background-color: #e9ecef;
}

.gallery-filter .nav-link.active {
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
    box-shadow: 0 3px 10px rgba(13, 110, 253, 0.25);
}

/* Gallery Card Styling */
.gallery-card {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    background-color: #fff;
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.gallery-img-container {
    position: relative;
    overflow: hidden;
    height: 0;
    padding-bottom: 75%;
}

.gallery-img-container img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallery-card:hover .gallery-img-container img {
    transform: scale(1.05);
}

/* Overlay Styling */
.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.1) 100%);
    display: flex;
    align-items: flex-end;
    opacity: 0;
    transition: opacity 0.3s ease;
    padding: 20px;
}

.gallery-card:hover .gallery-overlay {
    opacity: 1;
}

.overlay-content {
    width: 100%;
    text-align: center;
}

.gallery-title {
    font-size: 1.2rem;
    font-weight: 600;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
}

.gallery-meta {
    font-size: 0.85rem;
}

/* Responsive adjustments */
@media (max-width: 767px) {
    .gallery-filter .nav-link {
        margin-bottom: 10px;
        width: 100%;
        text-align: center;
    }
}
</style>