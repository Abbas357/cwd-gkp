{{-- <div class="cw-logo material">
    <a class="LogoWrapper dynamic-link" href="{{ route('site') }}" aria-label="Home">
        <div>
            <div class="cw-show-DeskTop-Tab">
                <img class="desktop-logo" style="border-bottom-right-radius: 50px" src="{{ asset('site/images/logo-desktop.gif') }}" alt="" />
            </div>

            <div class="cw-show-Mobile">
                <img src="{{ asset('site/images/logo-mobile.png') }}" class="mobile-logo" alt="CWD DEPT" />
            </div>
        </div>
    </a>
</div> --}}

<div id="cw-logo-container" class="cw-logo material">
</div>

<script>
    (function () {
        const screenWidth = window.innerWidth;
        let logoHtml = "";

        if (screenWidth > 768) {
            // Desktop logo for larger screens
            logoHtml = `
                <a class="LogoWrapper dynamic-link" href="{{ route('site') }}" aria-label="Home">
                    <div>
                        <div class="cw-show-DeskTop-Tab">
                            <img class="desktop-logo" style="border-bottom-right-radius: 50px" src="{{ asset('site/images/logo-desktop.gif') }}" alt="Desktop Logo" />
                        </div>
                    </div>
                </a>
            `;
        } else {
            // Mobile logo for smaller screens
            logoHtml = `
                <a class="LogoWrapper dynamic-link" href="{{ route('site') }}" aria-label="Home">
                    <div>
                        <div class="cw-show-Mobile">
                            <img src="{{ asset('site/images/logo-mobile.png') }}" class="mobile-logo" alt="Mobile Logo" />
                        </div>
                    </div>
                </a>
            `;
        }

        // Inject the dynamic content before the DOM is fully rendered
        document.getElementById("cw-logo-container").innerHTML = logoHtml;
    })();
</script>