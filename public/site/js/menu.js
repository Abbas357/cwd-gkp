(function ($) {
	const CWD = {
		matchMedia: window.matchMedia("(max-width: 1024px"),
		popover: $(".cw-top .right-column .cw-menu-popover"),
		integratedPlate: $("#integrated-plate"),
		topMenu: $(".cw-bottom .cw-top-menu-nav>li"),
		popoverBtn: $(".cw-menu-popover-btn"),
		searchIcon: $(".searchIcon"),
		mobileSearch: $(".cw-mobile-search"),
		cwTop: $(".cw-top"),
		cwBottom: $(".cw-bottom"),
		overlay: $(".CWD .popoverOverlay"),
		searchInput: $("#cw-search-input"),
		cancelBtn: $(".cw-search-cancel"),
		suggesstion: $(".cw-search .cw-suggesstion"),
		sugsContent: $(".cw-search .cw-suggesstion #content"),
		inputLoading: $(".input-loading"),
		searchWidget: $(".cw-search .widget"),
		lastScrollTop: 0,

		handleSearchIcon() {
			if (
				CWD.mobileSearch.hasClass("cw-mobile-search") &&
				CWD.matchMedia.matches
			) {
				setTimeout(() => {
					CWD.mobileSearch.removeClass("cw-mobile-search");
				}, 200);
				CWD.cwBottom.css("height", "68px");
			} else {
				CWD.mobileSearch.addClass("cw-mobile-search");
				CWD.cwBottom.css("height", "0px");
			}
		},

		handleMatchMedia() {
			if (!CWD.matchMedia.matches) {
				CWD.cwBottom.css("height", "50px");
			} else {
				CWD.cwBottom.css("height", "0px");
				CWD.mobileSearch.addClass("cw-mobile-search");
			}
		},

		throttle(func, limit) {
			let lastFunc;
			let lastRan;
			return function() {
				const context = this;
				const args = arguments;
				if (!lastRan) {
					func.apply(context, args);
					lastRan = Date.now();
				} else {
					clearTimeout(lastFunc);
					lastFunc = setTimeout(function() {
						if (Date.now() - lastRan >= limit) {
							func.apply(context, args);
							lastRan = Date.now();
						}
					}, limit - (Date.now() - lastRan));
				}
			};
		},

		handleSearchInput(e) {
			let debounceTimer;
			clearTimeout(debounceTimer);

			const input = e.target;
			CWD.inputLoading.addClass("cw-animated-border");
			CWD.searchWidget.css("display", "flex");

			CWD.sugsContent.empty();

			debounceTimer = setTimeout(() => {
				if (input.value.length > 2) {
					CWD.openSearch(input);
					$.ajax({
						url: "https://restcountries.com/v3.1/name/" + input.value,
						method: "GET",
						success: function (data) {
							CWD.searchWidget.css("display", "none");
							CWD.displayResults(data);
						},
						error: function (err) {
							CWD.displayErrors(err);
						},
						complete: function () {
							CWD.inputLoading.removeClass("cw-animated-border");
							CWD.searchWidget.css("display", "none");
						},
					});
				} else {
					CWD.closeSearch();
				}
			}, 1000);
		},

		displayResults(data) {
			CWD.sugsContent.empty();
			CWD.inputLoading.removeClass("cw-animated-border");
			CWD.searchWidget.css("display", "none");

			data.forEach((item) => {
				const li = $("<li>").addClass("cw-search-item");
				const img = $("<img>")
					.addClass("cw-search-item-image")
					.attr("src", item.flags.png);

				const div = $("<div>").html(
					`${item.name.common} (${item.name.official}) (<b>${item.capital}</b>)`
				);

				li.append(img).append(div);
				CWD.sugsContent.append(li);
			});
		},

		displayErrors() {
			CWD.sugsContent.empty();
			CWD.inputLoading.removeClass("cw-animated-border");
			CWD.searchWidget.css("display", "none");

			const li = $("<li>")
				.addClass("cw-search-error")
				.text("No results found. Please try a different Query");

			CWD.sugsContent.append(li);
		},

		openSearch(input) {
			CWD.cancelBtn.show();
			CWD.suggesstion.show();

			CWD.cancelBtn.on("click", function () {
				input.value = "";
				CWD.cancelBtn.hide();
				CWD.suggesstion.hide();
				CWD.searchInput.focus();
			});
		},

		closeSearch() {
			CWD.cancelBtn.hide();
			CWD.suggesstion.hide();
			CWD.inputLoading.removeClass("cw-animated-border");
			CWD.searchWidget.css("display", "none");
		},

		handleStickyBehavior() {
			const scrollThreshold = 100;
			const buffer = 50;
		
			if (window.scrollY > (scrollThreshold + buffer) && window.innerWidth > 900) {
				CWD.cwTop.addClass('d-none');
				CWD.cwBottom.css('opacity', '0.9');
			} else if (window.scrollY < (scrollThreshold - buffer) && window.innerWidth > 900) {
				CWD.cwTop.removeClass('d-none');
				CWD.cwBottom.css('opacity', '1')
			}
		},

	};

	$(document).ready(function () {
		CWD.searchIcon.on("click", CWD.handleSearchIcon);
		CWD.searchInput.on("input", CWD.handleSearchInput);
		$(window).on("resize", CWD.handleMatchMedia);
		$(document).on('scroll', CWD.throttle(CWD.handleStickyBehavior, 500));

		CWD.topMenu.on("mouseenter", function () {
			if ($(this).hasClass("child-nav") && window.innerWidth > 1024) {
				CWD.overlay.css({ top: "113px", display: "block" });
			}
		});

		CWD.topMenu.on("mouseleave", function () {
			CWD.overlay.hide();
		});

		CWD.popover.on("mouseenter", function () {
			if (window.innerWidth > 900) {
				CWD.overlay.css({ top: "65px", display: "block" });
			}
		});

		CWD.popover.on("mouseleave", function () {
			CWD.overlay.hide();
		});

		CWD.popoverBtn.on("click", function () {
			const el = $(this);
			const isExpanded =
				el.parentsUntil(".aria-expanded").last().attr("aria-expanded") ===
				"true";

			if (isExpanded) {
				CWD.overlay.hide();
			} else {
				CWD.overlay.css({ top: "65px", display: "block" });
			}
		});
		
	});
})(jQuery);