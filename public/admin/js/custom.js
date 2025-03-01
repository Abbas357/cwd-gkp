$(function () {
    "use strict";
    new PerfectScrollbar(".notify-list"),
        new PerfectScrollbar(".search-content");
    "true" === localStorage.getItem("sidebar-toggled") &&
        ($("body").addClass("toggled"),
        $(".sidebar-wrapper").hover(
            function () {
                $("body").addClass("sidebar-hovered");
            },
            function () {
                $("body").removeClass("sidebar-hovered");
            }
        )),
        $(".btn-toggle").click(function () {
            $("body").hasClass("toggled")
                ? ($("body").removeClass("toggled"),
                  $(".sidebar-wrapper").unbind("hover"),
                  localStorage.setItem("sidebar-toggled", !1))
                : ($("body").addClass("toggled"),
                  $(".sidebar-wrapper").hover(
                      function () {
                          $("body").addClass("sidebar-hovered");
                      },
                      function () {
                          $("body").removeClass("sidebar-hovered");
                      }
                  ),
                  localStorage.setItem("sidebar-toggled", !0));
        }),
        $(function () {
            $("#sidenav").metisMenu();
        }),
        $(".sidebar-close").on("click", function () {
            $("body").removeClass("toggled"),
                localStorage.setItem("sidebar-toggled", !1);
        });
    var e = localStorage.getItem("theme") || "light";
    function t(e) {
        $(".dark-mode i").attr(
            "class",
            "dark" === e ? "bi-brightness-high" : "bi-moon"
        );
    }
    $("html").attr("data-bs-theme", e),
        t(e),
        $(".dark-mode i").click(function () {
            $(this).attr("class", function () {
                return $(this).hasClass("bi-moon")
                    ? "bi-brightness-high"
                    : "bi-moon";
            });
        }),
        $(".dark-mode").click(function () {
            var e =
                "dark" === $("html").attr("data-bs-theme") ? "light" : "dark";
            $("html").attr("data-bs-theme", e),
                localStorage.setItem("theme", e),
                t(e);
        }),
        $("#LightTheme").on("click", function () {
            $("html").attr("data-bs-theme", "light"),
                localStorage.setItem("theme", "light");
        }),
        $("#DarkTheme").on("click", function () {
            $("html").attr("data-bs-theme", "dark"),
                localStorage.setItem("theme", "dark");
        }),
        $("#SemiDarkTheme").on("click", function () {
            $("html").attr("data-bs-theme", "semi-dark"),
                localStorage.setItem("theme", "semi-dark");
        }),
        $("#BoderedTheme").on("click", function () {
            $("html").attr("data-bs-theme", "bodered-theme"),
                localStorage.setItem("theme", "bodered-theme");
        }),
        $(".search-control").click(function () {
            $(".search-popup").addClass("d-block"),
                $(".search-close").addClass("d-block");
        }),
        $(".search-close").click(function () {
            $(".search-popup").removeClass("d-block"),
                $(".search-close").removeClass("d-block");
        }),
        $(".mobile-search-btn").click(function () {
            $(".search-popup").addClass("d-block");
        }),
        $(".mobile-search-close").click(function () {
            $(".search-popup").removeClass("d-block");
        }),
        $(function () {
            for (
                var e = window.location,
                    t = $(".metismenu li a")
                        .filter(function () {
                            return this.href == e;
                        })
                        .addClass("")
                        .parent()
                        .addClass("mm-active");
                t.is("li");

            )
                t = t
                    .parent("")
                    .addClass("mm-show")
                    .parent("")
                    .addClass("mm-active");
        }),
        $("div.modal").on("select2:open", () => {
            document.querySelector(".select2-search__field").focus();
        }),
        document.addEventListener("shown.bs.modal", function (e) {
            e = e.target.querySelector(".modal-body");
            e && new PerfectScrollbar(e);
        });
});

document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(event) {
        const button = form.querySelector('.cw-btn');
        if (button) {
            button.setAttribute('data-loading', 'true');
            button.disabled = true;
            
            setTimeout(() => form.submit(), 10);
        }
    });

    form.querySelectorAll('.cw-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();

                form.classList.add('was-validated');
            }
        });
    });
});

$(document).ready(function() {
    const $searchInput = $('.search-control');
    const $mobileSearchInput = $('.mobile-search-control');
    const $searchPopup = $('.search-popup');
    const $keywordsWrapper = $('.kewords-wrapper');
    const $searchList = $('.search-list');
    const $notifyList = $('.notify-list');
    const $badgeNotify = $('.badge-notify');

    let typingTimer;
    const doneTypingInterval = 500;
    let recentUrlMap = {};
    let currentPage = 1;
    let loading = false;
    let hasMorePages = true;

    function performSearch(query) {
        const url = linksURL + "?query=" + encodeURIComponent(query);
        $.getJSON(url, function(data) {
            data.results.forEach(result => {
                if (result.url && result.title) {
                    recentUrlMap[result.title.toLowerCase()] = result.url;
                }
            });

            $keywordsWrapper.html(data.recentSearches.map(search => {
                const url = recentUrlMap[search.toLowerCase()];
                return url ? `
                    <a href="${url}" class="kewords">
                        <span>${search}</span>
                        <i class="bi-arrow-right fs-6"></i>
                    </a>
                ` : `
                    <a href="javascript:;" class="kewords" onclick="$('.search-control').val('${search}');performSearch('${search}')">
                        <span>${search}</span>
                        <i class="bi-search fs-6"></i>
                    </a>
                `;
            }).join(''));

            if (data.results.length === 0) {
                $searchList.html(`
                    <div class="search-list-item">
                        <p class="text-muted mb-0">No links found</p>
                    </div>
                `);
            } else {
                $searchList.html(data.results.map(link => `
                    <div class="search-list-item">
                        <h5 class="mb-0 search-list-title">
                            <a href="${link.url}" class="text-decoration-none">
                                ${link.title}
                            </a>
                        </h5>
                    </div>
                `).join(''));
            }
        });
    }

    performSearch('');

    $searchInput.on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => performSearch($(this).val()), doneTypingInterval);
    });

    $mobileSearchInput.on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => performSearch($(this).val()), doneTypingInterval);
    });

    $searchInput.on('focus', () => $searchPopup.show());
    $('.search-close').on('click', () => $searchPopup.hide());
    $('.mobile-search-close').on('click', () => $searchPopup.hide());

    $('.dropdown-menu').on('click', function(e) {
        e.stopPropagation();
    });

    $('a[onclick*="collapseMenuItems"]').on('click', function() {
        $(this).find('i').toggleClass('rotate-180');
    });

    function fetchActivityLogs(page = 1, append = false) {
        if (loading || (!append && !hasMorePages)) return;
        
        loading = true;
        
        if (page === 1) {
            $notifyList.html(`
                <div class="text-center p-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mb-0 mt-3">Loading activity logs...</p>
                </div>
            `);
        } else if (append) {
            $notifyList.append(`
                <div class="text-center p-2 loading-indicator">
                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                </div>
            `);
        }
        
        const url = activityURL + "?page=" + encodeURIComponent(page) + "&perPage=5";
        $.getJSON(url)
            .done(data => {
                $('.loading-indicator').remove();
                
                if (!append) {
                    $notifyList.empty();
                }
                
                $badgeNotify.text(data.todayCount > 99 ? '99+' : data.todayCount)
                    .toggle(data.todayCount > 0);
                
                data.activities.forEach(activity => {
                    const todayIndicator = activity.is_today ? 
                        '<span class="badge bg-success rounded-pill ms-2">New</span>' : '';
                    
                    $notifyList.append(`
                        <a class="dropdown-item border-bottom py-2" href="javascript:;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="">
                                    <img src="${activity.causer_image}" class="rounded-circle" width="45" height="45" alt="">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="notify-title">${activity.description} ${todayIndicator}</h5>
                                    <p class="mb-0 notify-desc">By ${activity.causer_name} ${activity.subject_type ? 'on ' + activity.subject_type : ''}</p>
                                    <p class="mb-0 notify-time">${activity.time}</p>
                                </div>
                                <div class="notify-close position-absolute end-0 me-3">
                                    <i class="bi-x-circle fs-6"></i>
                                </div>
                            </div>
                        </a>
                    `);
                });
                
                if (data.activities.length === 0 && !append) {
                    $notifyList.html(`
                        <div class="text-center p-4">
                            <i class="bi bi-bell-slash fs-2 text-muted"></i>
                            <p class="mb-0 mt-2">No activity logs found</p>
                        </div>
                    `);
                }
                
                hasMorePages = data.hasMorePages;
                currentPage = page;
                loading = false;
            })
            .fail(error => {
                console.error('Error fetching activity logs:', error);
                loading = false;
                $('.loading-indicator').remove();
                
                if (!append) {
                    $notifyList.html(`
                        <div class="text-center p-4">
                            <i class="bi bi-exclamation-circle fs-2 text-danger"></i>
                            <p class="mb-0 mt-2">Failed to load notifications</p>
                        </div>
                    `);
                }
            });
    }

    fetchActivityLogs();

    $notifyList.on('scroll', function() {
        const $this = $(this);
        if ($this.scrollTop() + $this.innerHeight() >= $this[0].scrollHeight - 50 && 
            hasMorePages && !loading) {
            fetchActivityLogs(currentPage + 1, true);
        }
    });

    $('a.nav-link[data-bs-toggle="dropdown"]').on('click', function() {
        if (!$('.dropdown-notify').hasClass('show')) {
            currentPage = 1;
            hasMorePages = true;
            fetchActivityLogs();
        }
    });

    $notifyList.on('click', '.notify-close', function(e) {
        $(this).closest('.dropdown-item').remove();
    });
});