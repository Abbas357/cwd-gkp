<div class="tab-class text-center">
    <ul class="nav nav-pills d-inline-flex justify-content-center mb-5">
        @foreach($galleriesByType as $type => $galleries)
        @php
        $formattedType = ucfirst(str_replace('_', ' ', $type));
        @endphp
        <li class="nav-item">
            <a class="d-flex py-2 mx-3 border border-primary bg-light rounded-pill {{ $loop->first ? 'active' : '' }}" 
               data-bs-toggle="pill" href="#GalleryTab-{{ $type }}">
                <span class="text-dark" style="width: 150px;">{{ $formattedType }}</span>
            </a>
        </li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach($galleriesByType as $type => $galleries)
        <div id="GalleryTab-{{ $type }}" class="tab-pane fade show p-0 {{ $loop->first ? 'active' : '' }}">
            <div class="row g-2">
                @foreach($galleries as $gallery)
                <div class="col-sm-6 col-md-3">
                    <div class="gallery-item h-100">
                        <a href="{{ route('gallery.show', $gallery->slug) }}">
                            <img src="{{ $gallery->getFirstMediaUrl('gallery_covers') ?? asset('admin/images/no-image.jpg') }}" 
                                 alt="{{ $gallery->title }}" class="img-fluid rounded-top" />
                        </a>
                        <div class="gallery-content">
                            <div class="gallery-info">
                                <h5 class="text-white text-uppercase mb-2">{{ ucfirst(str_replace('_', ' ', $gallery->type)) }}</h5>
                                <h6 class="text-white text-uppercase mb-2">Images: {{ $gallery->items }}</h6>
                                <a href="{{ route('gallery.show', ['slug' => $gallery->slug]) }}" 
                                   class="btn-hover text-white">View Detail <i class="bi bi-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                        <div class="gallery-plus-icon">
                            <a href="{{ route('gallery.show', $gallery->slug) }}" class="text-white"><i class="bi-eye"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
