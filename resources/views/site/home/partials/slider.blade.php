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
                        srcset="{{ $slider['image']['small'] }} 400w, {{ $slider['image']['medium'] }} 800w, {{ $slider['image']['large'] }} 1200w" 
                        sizes="(max-width: 600px) 400px, (max-width: 1200px) 800px, 1200px" 
                        class="img-fluid" 
                        alt="{{ $slider['title'] }}">
                    
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <!-- Slider Title -->
                            <h3 class="text-white text-uppercase fw-bold mb-4 p-3" 
                                style="letter-spacing: 3px; background: #99999955; border-radius: 20px 20px 0px 0px">
                                {{ $slider['title'] }}
                            </h3>
                            
                            <!-- Slider Summary -->
                            <p class="mb-5 fs-5 p-3" style="background: #99999955; border-radius: 0px 0px 20px 20px">
                                {{ $slider['summary'] }}
                            </p>
                            
                            <!-- View Details Button -->
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn-hover-bg btn btn-primary rounded-pill text-white py-2 px-3" 
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
