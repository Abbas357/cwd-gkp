
<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<header id="integrated-plate" class="CWD">
    <div class="cw-top">
        <div class="cw-top-wrapper">
            <div class="left-column">
                <button class="cw-mobile-nav-toggle" tabindex="0" data-navigation-aria-label-text="Navigation" data-navigation-close-aria-label-text="Close" aria-label="Navigation">
                    <span class="cw-nav-menu-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                <div class="cw-logo material">
                    <a class="LogoWrapper dynamic-link" href="#" aria-label="Home">

                        <div>
                            <div class="cw-show-DeskTop-Tab">
                                <img src="{{ asset('web/img/logo-desktop.png') }}" class="desktop-logo" alt="CWD DEPT" />
                            </div>

                            <div class="cw-show-Mobile">
                                <img src="{{ asset('web/img/logo-mobile.png') }}" class="mobile-logo" alt="CWD DEPT" />
                            </div>
                        </div>
                    </a>
                </div>
                <div class="cw-search cw-search-temp-wrapper cw-mobile-search" role="search">
                    <div class="cw-input-container">
                        <input id="cw-search-input" type="search" class="cw-search-input" aria-label="Search..." placeholder="Search..." tabindex="0" autocomplete="off" />
                        <div class="input-loading"></div>
                        <button class="cw-search-btn cw-search-cancel" tabindex="0" aria-label="Cancel Search">
                            <i class="bi bi-x-circle"></i>
                        </button>
                        <button class="cw-search-btn cw-search-submit" tabindex="0" aria-label="Search...">
                            <i class="bi bi-search d-none d-sm-block"></i>
                        </button>
                    </div>
                    <div class="cw-suggesstion">
                        <div class="widget">
                            <header class="widget__header">
                                <h1 id="wait">Please wait <span class="dots">...</span></h1>
                            </header>
                            <div class="widget__body">
                                <div class="list-component list-loader"></div>
                            </div>
                        </div>
                        <ul id="content"></ul>
                    </div>
                </div>
            </div>
            <div class="right-column">
                <div class="d-none d-md-block cw-info">
                    <a href="mailto:info@cwd.gkp.pk"><i class="bi-envelope"></i> &nbsp; info@cwd.gkp.pk</a>
                    <a href="tel:+919210843"><i class="bi-telephone"></i> &nbsp; +919210843</a>
                </div>
                <div class="searchIcon">
                    <button class="btn cw-search-btn cw-search-submit" tabindex="0" aria-label="Search...">
                        <i class="bi-search"></i>
                        <span class="menu-label">SEARCH</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="cw-bottom">
        <div class="cw-bottom-wrapper">
            <div class="popoverOverlay"></div>
            <div id="integrated-plate-navigation" class="cw-nav" component="integrated-plate-navigation">
                <nav class="cw-top-nav">
                    <ul role="menu" class="cw-top-menu-nav aria-nav">
                        <li role="none" class="cw-top-menu child-nav" data-tier-id="4">
                            <button role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>HOME</span>
                            </button>

                            <ul class="sub-nav" aria-label="Support" role="menu" data-tier-id="4" aria-orientation="vertical">
                                <li role="none" class="cw-back-list-item">
                                    <button role="menuitem" class="cw-back-button" tabindex="0">
                                        <span class="cw-menu-chevron left chevron-right"></span>
                                        <span class="cw-back-button-label">Back </span>
                                    </button>
                                </li>
                                <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                    HOME
                                </li>
                                <li role="none" data-tier-id="4">
                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="4" tabindex="0">FAQ</a>
                                </li>
                                <li role="none" data-tier-id="4">
                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="4" tabindex="0">INTRODUCTION</a>
                                </li>
                                <li role="none" data-tier-id="4">
                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="4" tabindex="0">VISION</a>
                                </li>
                                <li role="none" data-tier-id="4">
                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="4" tabindex="0">FUNCTIONS</a>
                                </li>
                                <li role="none" data-tier-id="4">
                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="4" tabindex="0">ORGANOGRAM</a>
                                </li>
                                <li role="none" data-tier-id="4">
                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="4" tabindex="0">LIST OF EX-SECRETARIES</a>
                                </li>
                                <li role="none" data-tier-id="4">
                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="4" tabindex="0">BRIEF INTRODUCTION</a>
                                </li>
                            </ul>
                        </li>
                        <li role="none" class="cw-top-menu child-nav" data-tier-id="3">
                            <button role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>ATTACH FORMATIONS</span>
                            </button>

                            <ul class="sub-nav" aria-label="Services" role="menu" data-tier-id="3" aria-orientation="vertical">
                                <li role="none" class="cw-back-list-item">
                                    <button role="menuitem" class="cw-back-button" tabindex="0">
                                        <span class="cw-menu-chevron left chevron-right"></span>
                                        <span class="cw-back-button-label">Back </span>
                                    </button>
                                </li>
                                <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                    ATTACH FORMATIONS
                                </li>

                                <li role="none" class="child-nav" data-tier-id="3">
                                    <button role="menuitem" class="cw-menuItem" data-tier-id="3" tabindex="0" aria-expanded="false" aria-haspopup="true">
                                        CDO
                                    </button>
                                    <ul class="sub-nav" role="menu" data-tier-id="3" aria-label="Professional Services" aria-orientation="vertical">
                                        <li role="none" class="cw-back-list-item">
                                            <button role="menuitem" class="cw-back-button" tabindex="0">
                                                <span class="cw-menu-chevron left chevron-right"></span>
                                                <span class="cw-back-button-label">Back </span>
                                            </button>
                                        </li>
                                        <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                            CDO
                                        </li>
                                        <li role="none" data-tier-id="3">
                                            <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">INTRODUCTION</a>
                                        </li>

                                        <li role="none" class="child-nav" data-tier-id="3">
                                            <button role="menuitem" class="cw-menuItem" data-tier-id="3" tabindex="0" aria-expanded="false" aria-haspopup="true">
                                                DRAWINGS
                                            </button>
                                            <ul class="sub-nav" role="menu" data-tier-id="3" aria-label="Professional Services" aria-orientation="vertical">
                                                <li role="none" class="cw-back-list-item">
                                                    <button role="menuitem" class="cw-back-button" tabindex="0">
                                                        <span class="cw-menu-chevron left chevron-right"></span>
                                                        <span class="cw-back-button-label">Back
                                                        </span>
                                                    </button>
                                                </li>
                                                <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                                    DRAWINGS
                                                </li>
                                                <li role="none" data-tier-id="3">
                                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">1 KANAL</a>
                                                </li>
                                                <li role="none" data-tier-id="3">
                                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">2 KANALS</a>
                                                </li>
                                                <li role="none" data-tier-id="3">
                                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">3 KANALS</a>
                                                </li>
                                                <li role="none" data-tier-id="3">
                                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">4 KANALS</a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li role="none" class="child-nav" data-tier-id="3">
                                            <button role="menuitem" class="cw-menuItem" data-tier-id="3" tabindex="0" aria-expanded="false" aria-haspopup="true">
                                                SECTORS
                                            </button>
                                            <ul class="sub-nav" role="menu" data-tier-id="3" aria-label="Professional Services" aria-orientation="vertical">
                                                <li role="none" class="cw-back-list-item">
                                                    <button role="menuitem" class="cw-back-button" tabindex="0">
                                                        <span class="cw-menu-chevron left chevron-right"></span>
                                                        <span class="cw-back-button-label">Back
                                                        </span>
                                                    </button>
                                                </li>
                                                <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                                    DRAWINGS
                                                </li>
                                                <li role="none" data-tier-id="3">
                                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">HEALTH</a>
                                                </li>
                                                <li role="none" data-tier-id="3">
                                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">LAW & JUSTICE</a>
                                                </li>
                                                <li role="none" data-tier-id="3">
                                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">EDUCATION (ESE)</a>
                                                </li>
                                                <li role="none" data-tier-id="3">
                                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">SPORTS, CULTURE AND
                                                        TOURISM</a>
                                                </li>
                                                <li role="none" data-tier-id="3">
                                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">HOME DEPTT</a>
                                                </li>
                                                <li role="none" data-tier-id="3">
                                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">EDUCATION (HIGHER
                                                        EDUCATION)</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li role="none" class="child-nav" data-tier-id="3">
                                    <button role="menuitem" class="cw-menuItem" data-tier-id="3" tabindex="0" aria-expanded="false" aria-haspopup="true">
                                        KITE
                                    </button>

                                    <ul class="sub-nav" role="menu" data-tier-id="3" aria-label="Professional Services" aria-orientation="vertical">
                                        <li role="none" class="cw-back-list-item">
                                            <button role="menuitem" class="cw-back-button" tabindex="0">
                                                <span class="cw-menu-chevron left chevron-right"></span>
                                                <span class="cw-back-button-label">Back </span>
                                            </button>
                                        </li>
                                        <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                            KITE
                                        </li>
                                        <li role="none" data-tier-id="3">
                                            <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">INTRODUCTION</a>
                                        </li>
                                        <li role="none" data-tier-id="3">
                                            <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">SAFEGUARD DOCUMENTS</a>
                                        </li>
                                        <li role="none" data-tier-id="3">
                                            <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">PRESENTATION</a>
                                        </li>
                                    </ul>
                                </li>

                                <li role="none" data-tier-id="3">
                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">KP
                                        PRIP</a>
                                </li>

                                <li role="none" data-tier-id="3">
                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">KP
                                        RIISP</a>
                                </li>

                                <li role="none" data-tier-id="3">
                                    <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">KP
                                        RAP</a>
                                </li>

                                <li role="none" class="child-nav" data-tier-id="3">
                                    <button role="menuitem" class="cw-menuItem" data-tier-id="3" tabindex="0" aria-expanded="false" aria-haspopup="true">
                                        PaRSA
                                    </button>

                                    <ul class="sub-nav" role="menu" data-tier-id="3" aria-label="Professional Services" aria-orientation="vertical">
                                        <li role="none" class="cw-back-list-item">
                                            <button role="menuitem" class="cw-back-button" tabindex="0">
                                                <span class="cw-menu-chevron left chevron-right"></span>
                                                <span class="cw-back-button-label">Back </span>
                                            </button>
                                        </li>
                                        <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                            PaRSA
                                        </li>
                                        <li role="none" data-tier-id="3">
                                            <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">INTRODUCTION</a>
                                        </li>
                                        <li role="none" data-tier-id="3">
                                            <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">STANDARDIZATION OF SCHOOLS</a>
                                        </li>
                                        <li role="none" data-tier-id="3">
                                            <a role="menuitem" class="cw-menuItem" href="#" data-tier-id="3" tabindex="0">PRESENTATION</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li role="none" class="cw-top-menu" data-tier-id="4">
                            <a href="#" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>PROJECTS</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu" data-tier-id="4">
                            <a href="#" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>DOWNLOADS</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu" data-tier-id="4">
                            <a href="#" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>MEDIA</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu" data-tier-id="4">
                            <a href="#" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>NEWS</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu" data-tier-id="4">
                            <a href="#" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>EVENTS</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu" data-tier-id="4">
                            <a href="#" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>TEAM</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu" data-tier-id="4">
                            <a href="#" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>CONTACT</span>
                            </a>
                        </li>

                        <li role="menuitem" aria-hidden="true" class="divider cw-onlyMobileTab"></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
