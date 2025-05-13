<div class="carousel-header">
    <div id="homePageSlider" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        
        <ol class="carousel-indicators">
            @foreach($slides as $index => $slide)
                <li data-bs-target="#homePageSlider" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}">{{ $index + 1 }}</li>
            @endforeach
        </ol>
        
        <div class="carousel-inner" role="listbox">
            @foreach($slides as $index => $slide)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img 
                        src="{{ $slide['image']['large'] }}" 
                        srcset="
                            {{ $slide['image']['medium'] }} 768w, 
                            {{ $slide['image']['large'] }} 1000w, 
                            {{ $slide['image']['original'] }} 1200w"
                        sizes="(max-width: 768px) 768px, (max-width: 1000px) 1000px, 100vw" 
                        class="img-fluid" 
                        alt="{{ $slide['title'] }}">
                    
                    <div class="carousel-caption">
                        <div>
                            <h3 class="text-uppercase fw-bold">
                                {{ $slide['title'] }}
                            </h3>
                            
                            <div>
                                <a class="btn btn-primary" 
                                   href="{{ route('sliders.showSlider', $slide['slug']) }}">
                                   View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>        

        <button class="carousel-control-prev" type="button" data-bs-target="#homePageSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon btn bg-primary" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homePageSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon btn bg-primary" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('homePageSlider');
    if (carousel) {
        carousel.addEventListener('slide.bs.carousel', function() {
            const titles = document.querySelectorAll('.carousel-item:not(.active) .carousel-caption h3');
            const buttons = document.querySelectorAll('.carousel-item:not(.active) .carousel-caption .btn');
            
            titles.forEach(title => {
                title.style.opacity = '0';
                title.style.transform = 'translateX(-50px)';
            });
            
            buttons.forEach(button => {
                button.style.opacity = '0';
                button.style.transform = 'translateX(-50px)';
            });
        });
        
        const indicators = document.querySelectorAll('.carousel-indicators [data-bs-slide-to]');
        indicators.forEach((indicator, index) => {
            if (indicator.innerText === '') {
                indicator.innerText = index + 1;
            }
        });
    }
});
</script>