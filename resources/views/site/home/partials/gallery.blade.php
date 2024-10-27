<div class="container-fluid gallery py-3">
    <div class="mx-auto text-center my-5" style="max-width: 900px;">
        <h5 class="section-title px-3">Our Gallery</h5>
    </div>
    <div class="tab-class text-center">
        <!-- Tab buttons -->
        <ul class="nav nav-pills d-inline-flex justify-content-center mb-5">
            <!-- 'All' Tab -->
            <li class="nav-item">
                <a class="d-flex mx-3 py-2 border border-primary bg-light rounded-pill active" data-bs-toggle="pill" href="#GalleryTab-All">
                    <span class="text-dark" style="width: 150px;">All</span>
                </a>
            </li>
            <!-- Dynamic Type Tabs (limited to 5) -->
            @foreach($galleriesByType as $type => $galleries)
                @php
                    // Convert type to a human-readable format
                    $formattedType = ucfirst(str_replace('_', ' ', $type));
                @endphp
                <li class="nav-item">
                    <a class="d-flex py-2 mx-3 border border-primary bg-light rounded-pill" data-bs-toggle="pill" href="#GalleryTab-{{ $type }}">
                        <span class="text-dark" style="width: 150px;">{{ $formattedType }}</span>
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Tab content -->
        <div class="tab-content">
            <!-- 'All' Tab Content: Shows all galleries -->
            <div id="GalleryTab-All" class="tab-pane fade show p-0 active">
                <div class="row g-2">
                    @foreach($galleriesByType as $galleries)
                        @foreach($galleries as $gallery)
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="gallery-item h-100">
                                    <img src="{{ $gallery->getFirstMediaUrl('gallery') ?: asset('admin/images/no-image.jpg') }}" class="img-fluid w-100 h-100 rounded" alt="{{ $gallery->title }}">
                                    <div class="gallery-content">
                                        <div class="gallery-info">
                                            <h5 class="text-white text-uppercase mb-2">{{ ucfirst(str_replace('_', ' ', $gallery->type)) }}</h5>
                                            <a href="{{ route('gallery.show', ['slug' => $gallery->slug]) }}" class="btn-hover text-white">View Detail <i class="bi bi-arrow-right ms-2"></i></a>
                                        </div>
                                    </div>
                                    <div class="gallery-plus-icon">
                                        <a href="{{ $gallery->getFirstMediaUrl('gallery') }}" data-lightbox="gallery-{{ $gallery->id }}" class="my-auto"><i class="bi bi-plus fs-1 text-white"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
            
            <!-- Dynamic Tab Content for Each Type (limited to 5) -->
            @foreach($galleriesByType as $type => $galleries)
                <div id="GalleryTab-{{ $type }}" class="tab-pane fade show p-0">
                    <div class="row g-2">
                        @foreach($galleries as $gallery)
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                <div class="gallery-item h-100">
                                    <img src="{{ $gallery->getFirstMediaUrl('gallery') ?: asset('admin/images/no-image.jpg') }}" class="img-fluid w-100 h-100 rounded" alt="{{ $gallery->title }}">
                                    <div class="gallery-content">
                                        <div class="gallery-info">
                                            <h5 class="text-white text-uppercase mb-2">{{ ucfirst(str_replace('_', ' ', $gallery->type)) }}</h5>
                                            <a href="{{ route('gallery.show', ['slug' => $gallery->slug]) }}" class="btn-hover text-white">View Detail <i class="bi bi-arrow-right ms-2"></i></a>
                                        </div>
                                    </div>
                                    <div class="gallery-plus-icon">
                                        <a href="{{ $gallery->getFirstMediaUrl('gallery') }}" data-lightbox="gallery-{{ $gallery->id }}" class="my-auto"><i class="bi bi-plus fs-1 text-white"></i></a>
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
