<div class="carousel-header">
    <div id="homePageSlider" class="carousel slide" data-bs-ride="carousel">
        
        <!-- Carousel Indicators -->
        <ol class="carousel-indicators">
            @foreach($sliders as $index => $slider)
                <li data-bs-target="#homePageSlider" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
            @endforeach
        </ol>
        
        <!-- Carousel Inner -->
        <div class="carousel-inner" role="listbox">
            @foreach($sliders as $index => $slider)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <!-- Responsive Image -->
                    <img 
                        src="{{ $slider['image']['large'] }}" 
                        srcset="
                            {{ $slider['image']['medium'] }} 768w, 
                            {{ $slider['image']['large'] }} 1000w, 
                            {{ $slider['image']['original'] }} 1200w"
                        sizes="(max-width: 768px) 768px, (max-width: 1000px) 1000px, 100vw" 
                        class="img-fluid" 
                        alt="{{ $slider['title'] }}">
                    
                    <div class="carousel-caption">
                        <div class="p-3">
                            <h3 class="text-uppercase fw-bold mb-2 p-3">
                                {{ $slider['title'] }}
                            </h3>
                            
                            <p class="mb-2 fs-5 p-3">
                                {{ $slider['summary'] }}
                            </p>
                            
                            <div>
                                <a class="btn-hover-bg btn btn-primary text-white py-2 px-3" 
                                   href="{{ route('sliders.showSlider', $slider['slug']) }}">
                                   View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>        

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#homePageSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon btn bg-primary" aria-hidden="false"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homePageSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon btn bg-primary" aria-hidden="false"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
