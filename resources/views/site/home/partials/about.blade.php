<div class="row g-5 align-items-center">
    <div class="col-lg-5">
        <div class="h-100" style="border: 30px solid; border-color: transparent #dddddd transparent #dddddd;">
            <!-- Dynamic image from $aboutData with fallback -->
            <img src="{{ $aboutData['image'] }}" class="img-fluid w-100 h-100" alt="{{ $aboutData['title'] }}">
        </div>
    </div>
    <div class="col-lg-7" style="background: linear-gradient(rgba(255, 255, 255, .8), rgba(255, 255, 255, .8))');">
        <!-- Dynamic title and content -->
        <p class="mb-4">{!! $aboutData['content'] !!}</p>
    </div>
</div>
