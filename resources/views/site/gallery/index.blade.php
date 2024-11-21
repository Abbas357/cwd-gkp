<x-main-layout title="Gallery">
    <x-slot name="breadcrumbTitle">
        Gallery
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Gallery</li>
    </x-slot>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-3">
                <ul class="nav nav-pills flex-column bg-light rounded p-3 shadow-sm" id="galleryTabs" role="tablist">
                    @foreach ($galleriesByType as $type => $galleries)
                    @if(!empty($galleries))
                    <li class="nav-item mb-2" role="presentation">
                        <a class="nav-link @if($loop->first) active @endif p-2 fw-bold" id="tab-{{ Str::slug($type) }}" data-bs-toggle="tab" href="#{{ Str::slug($type) }}" role="tab" aria-controls="{{ Str::slug($type) }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>

            <div class="col-md-9">
                <div class="tab-content" id="galleryTabContent">
                    @foreach ($galleriesByType as $type => $galleries)
                    @if(!empty($galleries))
                    <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ Str::slug($type) }}" role="tabpanel" aria-labelledby="tab-{{ Str::slug($type) }}">
                        <h4 class="mt-3 mb-3 text-primary">{{ ucfirst(str_replace('_', ' ', $type)) }} Gallery</h4>
                        <div class="row">
                            @foreach ($galleries as $gallery)
                            @if(!empty($gallery->title) || !empty($gallery->slug) || !empty($gallery->items))
                            <div class="card col-md-4 mb-4 shadow-sm">
                                @if(!empty($gallery->slug))
                                <a href="{{ route('gallery.show', $gallery->slug) }}">
                                    <img src="{{ $gallery->getFirstMediaUrl('gallery_covers') ?? asset('admin/images/no-image.jpg') }}" alt="{{ $gallery->title }}" class="img-fluid rounded-top" />
                                </a>
                                @endif

                                <div class="card-body">
                                    @if(!empty($gallery->title))
                                    <h5 class="card-title">{{ $gallery->title }}</h5>
                                    @endif
                                    @if(!empty($gallery->items))
                                    <p class="card-text">Number of Items: {{ $gallery->items }}</p>
                                    @endif
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
