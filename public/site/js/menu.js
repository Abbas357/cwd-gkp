!(function (t) {
    const n = {
        matchMedia: window.matchMedia("(max-width: 1024px"),
        popover: t(".cw-top .right-column .cw-menu-popover"),
        integratedPlate: t("#integrated-plate"),
        topMenu: t(".cw-bottom .cw-top-menu-nav>li"),
        popoverBtn: t(".cw-menu-popover-btn"),
        mobileSearch: t(".cw-mobile-search"),
        cwTop: t(".cw-top"),
        cwBottom: t(".cw-bottom"),
        overlay: t(".CWD .popoverOverlay"),
        searchInput: t("#cw-search-input"),
        cancelBtn: t(".cw-search-cancel"),
        suggesstion: t(".cw-search .cw-suggesstion"),
        sugsContent: t(".cw-search .cw-suggesstion #content"),
        inputLoading: t(".input-loading"),
        searchWidget: t(".cw-search .widget"),
        lastScrollTop: 0,
        handleMatchMedia() {
            n.matchMedia.matches
                ? (n.cwBottom.css("height", "0px"),
                  n.mobileSearch.addClass("cw-mobile-search"))
                : n.cwBottom.css("height", "50px");
        },
        throttle(t, n) {
            let a, s;
            return function () {
                const e = this,
                    o = arguments;
                s
                    ? (clearTimeout(a),
                      (a = setTimeout(function () {
                          Date.now() - s >= n &&
                              (t.apply(e, o), (s = Date.now()));
                      }, n - (Date.now() - s))))
                    : (t.apply(e, o), (s = Date.now()));
            };
        },
        handleSearchInput(e) {
            clearTimeout(void 0);
            const o = e.target;
            n.inputLoading.addClass("cw-animated-border"),
                n.searchWidget.css("display", "flex"),
                n.sugsContent.empty(),
                setTimeout(() => {
                    2 < o.value.length
                        ? (n.openSearch(o),
                          t.ajax({
                              url: "/search",
                              data: { query: o.value },
                              method: "GET",
                              success: function (e) {
                                  e.success &&
                                      (n.searchWidget.css("display", "none"),
                                      n.displayResults(e.data));
                              },
                              complete: function () {
                                  n.inputLoading.removeClass(
                                      "cw-animated-border"
                                  ),
                                      n.searchWidget.css("display", "none");
                              },
                          }))
                        : n.closeSearch();
                }, 1e3);
        },
        displayResults(e) {
            n.sugsContent.empty(),
                n.inputLoading.removeClass("cw-animated-border"),
                n.searchWidget.css("display", "none"),
                console.log(e.result),
                n.sugsContent.html(e.result);
        },
        displayErrors() {
            n.sugsContent.empty(),
                n.inputLoading.removeClass("cw-animated-border"),
                n.searchWidget.css("display", "none");
            var e = t("<li>")
                .addClass("cw-search-error")
                .text("No results found. Please try a different Query");
            n.sugsContent.append(e);
        },
        openSearch(e) {
            n.cancelBtn.show(),
                n.suggesstion.show(),
                n.cancelBtn.on("click", function () {
                    (e.value = ""),
                        n.cancelBtn.hide(),
                        n.suggesstion.hide(),
                        n.searchInput.focus();
                });
        },
        closeSearch() {
            n.cancelBtn.hide(),
                n.suggesstion.hide(),
                n.inputLoading.removeClass("cw-animated-border"),
                n.searchWidget.css("display", "none");
        },
        handleStickyBehavior() {
            150 < window.scrollY && 900 < window.innerWidth
                ? (n.cwTop.addClass("d-none"), n.cwBottom.css("opacity", "0.9"))
                : window.scrollY < 50 &&
                  900 < window.innerWidth &&
                  (n.cwTop.removeClass("d-none"),
                  n.cwBottom.css("opacity", "1"));
        },
    };
    t(document).ready(function () {
        n.searchInput.on("input", n.handleSearchInput),
            t(window).on("resize", n.handleMatchMedia),
            t(document).on("scroll", n.throttle(n.handleStickyBehavior, 500)),
            n.topMenu.on("mouseenter", function () {
                t(this).hasClass("child-nav") &&
                    1024 < window.innerWidth &&
                    n.overlay.css({ top: "113px", display: "block" });
            }),
            n.topMenu.on("mouseleave", function () {
                n.overlay.hide();
            }),
            n.popover.on("mouseenter", function () {
                900 < window.innerWidth &&
                    n.overlay.css({ top: "65px", display: "block" });
            }),
            n.popover.on("mouseleave", function () {
                n.overlay.hide();
            }),
            n.popoverBtn.on("click", function () {
                "true" ===
                t(this)
                    .parentsUntil(".aria-expanded")
                    .last()
                    .attr("aria-expanded")
                    ? n.overlay.hide()
                    : n.overlay.css({ top: "65px", display: "block" });
            });
    });
})(jQuery);
