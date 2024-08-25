<button class="btn btn-primary rounded-10 position-fixed bottom-0 end-0 m-3 d-flex align-items-center gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop">
    <i class="material-symbols-outlined">tune</i>
</button>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="staticBackdrop">
    <div class="offcanvas-header border-bottom h-70">
        <div class="">
            <h5 class="mb-0">Theme Customizer</h5>
            <p class="mb-0">Customize your theme</p>
        </div>
        <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
            <i class="material-symbols-outlined">close</i>
        </a>
    </div>
    <div class="offcanvas-body">
        <div>
            <p>Theme variation</p>

            <div class="row g-3">
                <div class="col-12 col-xl-6">
                    <input type="radio" class="btn-check" name="theme-options" id="LightTheme">
                    <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="LightTheme">
                        <span class="material-symbols-outlined">light_mode</span>
                        <span>Light</span>
                    </label>
                </div>
                <div class="col-12 col-xl-6">
                    <input type="radio" class="btn-check" name="theme-options" id="DarkTheme">
                    <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="DarkTheme">
                        <span class="material-symbols-outlined">dark_mode</span>
                        <span>Dark</span>
                    </label>
                </div>
                <div class="col-12 col-xl-6">
                    <input type="radio" class="btn-check" name="theme-options" id="SemiDarkTheme">
                    <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="SemiDarkTheme">
                        <span class="material-symbols-outlined">contrast</span>
                        <span>Semi Dark</span>
                    </label>
                </div>
                <div class="col-12 col-xl-6">
                    <input type="radio" class="btn-check" name="theme-options" id="BoderedTheme">
                    <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="BoderedTheme">
                        <span class="material-symbols-outlined">border_style</span>
                        <span>Bordered</span>
                    </label>
                </div>
            </div>
            <!--end row-->

        </div>
    </div>
</div>
