$(function () {
  "use strict";

  /* scrollar */

  new PerfectScrollbar(".notify-list");
  new PerfectScrollbar(".search-content");

  /* Load sidebar toggle state from localStorage */
  const isToggled = localStorage.getItem("sidebar-toggled") === "true";
  if (isToggled) {
      $("body").addClass("toggled");
      $(".sidebar-wrapper").hover(
          function () {
              $("body").addClass("sidebar-hovered");
          },
          function () {
              $("body").removeClass("sidebar-hovered");
          }
      );
  }

  /* toggle button */
  $(".btn-toggle").click(function () {
      if ($("body").hasClass("toggled")) {
          $("body").removeClass("toggled");
          $(".sidebar-wrapper").unbind("hover");
          localStorage.setItem("sidebar-toggled", false);
      } else {
          $("body").addClass("toggled");
          $(".sidebar-wrapper").hover(
              function () {
                  $("body").addClass("sidebar-hovered");
              },
              function () {
                  $("body").removeClass("sidebar-hovered");
              }
          );
          localStorage.setItem("sidebar-toggled", true);
      }
  });

  /* menu */

  $(function () {
      $("#sidenav").metisMenu();
  });

  $(".sidebar-close").on("click", function () {
      $("body").removeClass("toggled");
      localStorage.setItem("sidebar-toggled", false);
  });

  /* Load theme from localStorage */
  const savedTheme = localStorage.getItem("theme") || "light";
  $("html").attr("data-bs-theme", savedTheme);
  updateDarkModeIcon(savedTheme);

  /* dark mode button */

  $(".dark-mode i").click(function () {
      $(this).text(function (i, v) {
          return v === "dark_mode" ? "light_mode" : "dark_mode";
      });
  });

  $(".dark-mode").click(function () {
      const newTheme = $("html").attr("data-bs-theme") === "dark" ? "light" : "dark";
      $("html").attr("data-bs-theme", newTheme);
      localStorage.setItem("theme", newTheme);
      updateDarkModeIcon(newTheme);
  });

  function updateDarkModeIcon(theme) {
      $(".dark-mode i").text(theme === "dark" ? "light_mode" : "dark_mode");
  }

  /* switcher */

  $("#LightTheme").on("click", function () {
      $("html").attr("data-bs-theme", "light");
      localStorage.setItem("theme", "light");
  });
  $("#DarkTheme").on("click", function () {
      $("html").attr("data-bs-theme", "dark");
      localStorage.setItem("theme", "dark");
  });
  $("#SemiDarkTheme").on("click", function () {
      $("html").attr("data-bs-theme", "semi-dark");
      localStorage.setItem("theme", "semi-dark");
  });
  $("#BoderedTheme").on("click", function () {
      $("html").attr("data-bs-theme", "bodered-theme");
      localStorage.setItem("theme", "bodered-theme");
  });

  /* search control */

  $(".search-control").click(function () {
      $(".search-popup").addClass("d-block");
      $(".search-close").addClass("d-block");
  });

  $(".search-close").click(function () {
      $(".search-popup").removeClass("d-block");
      $(".search-close").removeClass("d-block");
  });

  $(".mobile-search-btn").click(function () {
      $(".search-popup").addClass("d-block");
  });

  $(".mobile-search-close").click(function () {
      $(".search-popup").removeClass("d-block");
  });

  /* menu active */

  $(function () {
      var e = window.location;
      var o = $(".metismenu li a")
          .filter(function () {
              return this.href == e;
          })
          .addClass("")
          .parent()
          .addClass("mm-active");
      while (o.is("li")) {
          o = o.parent("").addClass("mm-show").parent("").addClass("mm-active");
      }
  });
});