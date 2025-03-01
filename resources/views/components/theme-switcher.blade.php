<button class="btn btn-primary rounded-10 position-fixed bottom-0 end-0 m-3 d-flex align-items-center gap-2" style="z-index:9999" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop">
    <i class="bi bi-gear-fill"></i>
</button>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="staticBackdrop">
    <div class="offcanvas-header border-bottom h-70">
        <div class="">
            <h5 class="mb-0">Theme Customizer</h5>
            <p class="mb-0">Customize your theme</p>
        </div>
        <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
            <i class="bi bi-x-circle"></i>
        </a>
    </div>
    <div class="offcanvas-body">
        <div>
            <p>Theme variation</p>

            <div class="row g-3">
                @foreach ($themes as $theme)
                    <div class="col-12 col-xl-6">
                        <input type="radio" class="btn-check" name="theme-options" id="{{ $theme['id'] }}" {{ $currentTheme == $theme['id'] ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="{{ $theme['id'] }}">
                            <i class="{{ $theme['icon'] }}"></i>
                            <span>{{ $theme['label'] }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>