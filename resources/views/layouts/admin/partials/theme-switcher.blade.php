<button class="btn btn-primary rounded-10 position-fixed bottom-0 end-0 m-3 d-flex align-items-center gap-2" style="z-index:9999" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop">
    <i class="bi-gear-fill"></i>
</button>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="staticBackdrop">
    <div class="offcanvas-header border-bottom h-70">
        <div class="">
            <h5 class="mb-0">Theme Customizer</h5>
            <p class="mb-0">Customize your theme</p>
        </div>
        <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
            <i class="bi-x-circle"></i>
        </a>
    </div>
    <div class="offcanvas-body">
        <div>
            <p>Theme variation</p>

            <div class="row g-3">
                <div class="col-12 col-xl-6">
                    <input type="radio" class="btn-check" name="theme-options" id="LightTheme">
                    <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="LightTheme">
                        <i class="bi-brightness-high"></i>
                        <span>Light</span>
                    </label>
                </div>
                <div class="col-12 col-xl-6">
                    <input type="radio" class="btn-check" name="theme-options" id="DarkTheme">
                    <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="DarkTheme">
                        <i class="bi-moon"></i>
                        <span>Dark</span>
                    </label>
                </div>
                <div class="col-12 col-xl-6">
                    <input type="radio" class="btn-check" name="theme-options" id="SemiDarkTheme">
                    <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="SemiDarkTheme">
                        <i class="bi-circle-half"></i>
                        <span>Semi Dark</span>
                    </label>
                </div>
                <div class="col-12 col-xl-6">
                    <input type="radio" class="btn-check" name="theme-options" id="BoderedTheme">
                    <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="BoderedTheme">
                        <i class="bi-border-style"></i>
                        <span>Bordered</span>
                    </label>
                </div>
            </div>
            <!--end row-->

        </div>
    </div>
</div>
