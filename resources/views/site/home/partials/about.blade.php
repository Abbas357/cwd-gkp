<div class="container py-2">
    <div class="mx-auto text-center mb-5" style="max-width: 900px;">
        <h5 class="section-title px-3">About US</h5>
    </div>
    <div class="row g-5 align-items-center">
        <div class="col-lg-5">
            <div class="h-100" style="border: 30px solid; border-color: transparent #13357B transparent #13357B;">
                <!-- Dynamic image from $aboutData with fallback -->
                <img src="{{ $aboutData['image'] }}" class="img-fluid w-100 h-100" alt="{{ $aboutData['title'] }}">
            </div>
        </div>
        <div class="col-lg-7" style="background: linear-gradient(rgba(255, 255, 255, .8), rgba(255, 255, 255, .8)), url('{{ asset('img/about-img-1.png') }}');">
            <!-- Dynamic title and content -->
            <p class="mb-4">{!! $aboutData['content'] !!}</p>
        </div>
    </div>
</div>
</div>
