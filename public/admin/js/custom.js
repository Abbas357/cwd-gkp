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