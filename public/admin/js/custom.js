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
    // $("html").attr("data-bs-theme", e),
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
        $(".mobile-search-btn").click(function () {
            $(".search-popup").addClass("d-block");
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

document.querySelectorAll("form").forEach((form) => {
    form.addEventListener("submit", async function (event) {
        const button = form.querySelector(".cw-btn");

        if (button && button.hasAttribute('confirm')) {
            event.preventDefault();
            
            const message = button.getAttribute('confirm');
            
            try {
                const result = await confirmAction(message);
                if (result && result.isConfirmed) {
                    button.setAttribute("data-loading", "true");
                    button.disabled = true;
                    
                    setTimeout(() => form.submit(), 10);
                }
            } catch (error) {
                console.error("Confirmation error:", error);
            }
            return;
        } else {
            button.setAttribute("data-loading", "true");
            button.disabled = true;
            setTimeout(() => form.submit(), 10);
        }
    });

    form.querySelectorAll(".cw-btn").forEach((button) => {
        button.addEventListener("click", function (e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();

                form.classList.add("was-validated");
            }
        });
    });
});

$(document).ready(function () {
    const $searchInput = $(".search-control");
    const $mobileSearchInput = $(".mobile-search-control");
    const $searchPopup = $(".search-popup");
    const $keywordsWrapper = $(".kewords-wrapper");
    const $searchList = $(".search-list");
    const $notifyList = $(".notify-list");
    const $badgeNotify = $(".badge-notify");

    let typingTimer;
    const doneTypingInterval = 500;
    let recentUrlMap = {};
    let currentPage = 1;
    let loading = false;
    let hasMorePages = true;

    function performSearch(query) {
        const url = linksURL + "?query=" + encodeURIComponent(query);
        $.getJSON(url, function (data) {
            data.results.forEach((result) => {
                if (result.url && result.title) {
                    recentUrlMap[result.title.toLowerCase()] = result.url;
                }
            });

            $keywordsWrapper.html(
                data.recentSearches
                    .map((search) => {
                        const url = recentUrlMap[search.toLowerCase()];
                        return url
                            ? `
                    <a href="${url}" class="kewords">
                        <span>${search}</span>
                        <i class="bi-arrow-right fs-6"></i>
                    </a>
                `
                            : `
                    <a href="javascript:;" class="kewords" onclick="$('.search-control').val('${search}');performSearch('${search}')">
                        <span>${search}</span>
                        <i class="bi-search fs-6"></i>
                    </a>
                `;
                    })
                    .join("")
            );

            if (data.results.length === 0) {
                $searchList.html(`
                    <div class="search-list-item">
                        <p class="text-muted mb-0">No links found</p>
                    </div>
                `);
            } else {
                $searchList.html(
                    data.results
                        .map(
                            (link) => `
                    <div class="search-list-item">
                        <h5 class="mb-0 search-list-title">
                            <a href="${link.url}" class="text-decoration-none">
                                ${link.title}
                            </a>
                        </h5>
                    </div>
                `
                        )
                        .join("")
                );
            }
        });
    }

    performSearch("");

    $searchInput.on("keyup", function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(
            () => performSearch($(this).val()),
            doneTypingInterval
        );
    });

    $mobileSearchInput.on("keyup", function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(
            () => performSearch($(this).val()),
            doneTypingInterval
        );
    });

    $searchInput.on("focus", () => $searchPopup.show());
    $(".search-close").on("click", () => $searchPopup.hide());
    $(".mobile-search-close").on("click", () => $searchPopup.hide());

    $(".dropdown-menu").on("click", function (e) {
        e.stopPropagation();
    });

    $('a[onclick*="collapseMenuItems"]').on("click", function () {
        $(this).find("i").toggleClass("rotate-180");
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

        const url =
            activityURL + "?page=" + encodeURIComponent(page) + "&perPage=5";
        $.getJSON(url)
            .done((data) => {
                $(".loading-indicator").remove();

                if (!append) {
                    $notifyList.empty();
                }

                $badgeNotify
                    .text(data.todayCount > 99 ? "99+" : data.todayCount)
                    .toggle(data.todayCount > 0);

                data.activities.forEach((activity) => {
                    const todayIndicator = activity.is_today
                        ? '<span class="badge bg-success rounded-pill ms-2">New</span>'
                        : "";

                    $notifyList.append(`
                        <a class="dropdown-item border-bottom py-2" href="javascript:;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="">
                                    <img src="${
                                        activity.causer_image
                                    }" class="rounded-circle" width="45" height="45" alt="">
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="notify-title">${
                                        activity.description
                                    } ${todayIndicator}</h5>
                                    <p class="mb-0 notify-desc">By ${
                                        activity.causer_name
                                    } ${
                                        activity.subject_type
                                            ? "on " + activity.subject_type
                                            : ""
                                    }</p>
                                    <p class="mb-0 notify-time">${
                                        activity.time
                                    }</p>
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
            .fail((error) => {
                console.error("Error fetching activity logs:", error);
                loading = false;
                $(".loading-indicator").remove();

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

    $notifyList.on("scroll", function () {
        const $this = $(this);
        if (
            $this.scrollTop() + $this.innerHeight() >=
                $this[0].scrollHeight - 50 &&
            hasMorePages &&
            !loading
        ) {
            fetchActivityLogs(currentPage + 1, true);
        }
    });

    $('a.nav-link[data-bs-toggle="dropdown"]').on("click", function () {
        if (!$(".dropdown-notify").hasClass("show")) {
            currentPage = 1;
            hasMorePages = true;
            fetchActivityLogs();
        }
    });

    $notifyList.on("click", ".notify-close", function (e) {
        $(this).closest(".dropdown-item").remove();
    });

    $(document).on('click', function(e) {
        const popup = $(".search-popup");
        const input = $(".admin-search");
        const searchBtn = $(".mobile-search-btn");
    
        if (
            !popup.is(e.target) && popup.has(e.target).length === 0 &&
            !searchBtn.is(e.target) && searchBtn.has(e.target).length === 0 &&
            !input.is(e.target) && input.has(e.target).length === 0
        ) {
            popup.removeClass("d-block");
            popup[0].style.display = 'none';
        }

    });

});

$(document).on('select2:open', function () {
    setTimeout(function () {
        let searchField = document.querySelector('.select2-container--open .select2-search__field');
        if (searchField) {
            searchField.focus();
            searchField.placeholder = 'Search...';
        }
    }, 0);
});

window.addEventListener('error', function(e) {
    if (e.message.includes('Extension context invalidated') || 
        e.message.includes('runtime.lastError')) {
        e.preventDefault();
        return true;
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const minimizedModals = new Map();
    let minimizedCount = 0;
    
    const createMinimizeContainer = () => {
        if (!document.getElementById('minimized-modals-container')) {
            const container = document.createElement('div');
            container.id = 'minimized-modals-container';
            container.style.cssText = `
                position: fixed;
                bottom: 0;
                left: 0;
                display: flex;
                gap: 10px;
                padding: 10px;
                z-index: 1055;
                flex-wrap: wrap;
                max-width: 100%;
            `;
            document.body.appendChild(container);
        }
    };
    
    const manageBodyScroll = (disable = false) => {
        if (disable) {
            // Disable body scroll
            const scrollBarWidth = window.innerWidth - document.documentElement.clientWidth;
            document.body.style.overflow = 'hidden';
            document.body.style.paddingRight = scrollBarWidth + 'px';
        } else {
            // Enable body scroll only if no maximized modals exist
            const hasMaximizedModals = document.querySelector('.modal-fullscreen');
            if (!hasMaximizedModals) {
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            }
        }
    };
    
    const initializeModal = (modal) => {
        if (!modal.hasAttribute('draggable-modal')) return;
        
        const modalDialog = modal.querySelector('.modal-dialog');
        const modalHeader = modal.querySelector('.modal-header');
        const modalTitle = modal.querySelector('.modal-title');
        
        if (!modalHeader || modal.dataset.draggableInitialized === 'true') return;
        
        modal.dataset.draggableInitialized = 'true';

        if (!modal.querySelector('.btn-minimize')) {
            const windowControls = document.createElement('div');
            windowControls.style.cssText = `
                display: flex;
                align-items: center;
                gap: 2px;
            `;
            
            const maximizeBtn = document.createElement('button');
            maximizeBtn.className = 'btn-maximize';
            maximizeBtn.type = 'button';
            maximizeBtn.setAttribute('aria-label', 'Maximize');
            maximizeBtn.style.cssText = `
                box-sizing: content-box;
                width: 1em;
                height: 1em;
                padding: 0.25em 0.25em;
                color: #000;
                background: transparent;
                border: 0;
                border-radius: 0.375rem;
                opacity: 0.5;
                cursor: pointer;
                font-size: 1.5rem;
                line-height: 1;
                transition: opacity 0.15s;
                font-family: Arial, sans-serif;
            `;
            maximizeBtn.innerHTML = '□';
            maximizeBtn.title = 'Maximize';
            
            const minimizeBtn = document.createElement('button');
            minimizeBtn.className = 'btn-minimize';
            minimizeBtn.type = 'button';
            minimizeBtn.setAttribute('aria-label', 'Minimize');
            minimizeBtn.style.cssText = `
                box-sizing: content-box;
                width: 1em;
                height: .5em;
                padding: 0.25em 0.25em;
                color: #000;
                background: transparent;
                border: 0;
                border-radius: 0.375rem;
                opacity: 0.5;
                cursor: pointer;
                font-size: 1.2rem;
                font-weight: 700;
                line-height: 1;
                transition: opacity 0.15s;
            `;
            minimizeBtn.innerHTML = '−';
            minimizeBtn.title = 'Minimize';
            
            [minimizeBtn, maximizeBtn].forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.opacity = '0.75';
                });
                btn.addEventListener('mouseleave', function() {
                    this.style.opacity = '0.5';
                });
            });
            
            const closeBtn = modalHeader.querySelector('.btn-close');
            if (closeBtn) {
                const parent = closeBtn.parentNode;
                
                windowControls.appendChild(minimizeBtn);
                windowControls.appendChild(maximizeBtn);
                windowControls.appendChild(closeBtn);
                
                parent.appendChild(windowControls);
            }
            
            let isMaximized = false;
            let originalTransform = '';
            let originalBodyStyle = '';

            const toggleMaximize = () => {
                const modalDialog = modal.querySelector('.modal-dialog');
                const modalBody = modal.querySelector('.modal-body');
                
                if (!isMaximized) {
                    originalTransform = modalDialog.style.transform || 'translate(0, 0)';
                    originalBodyStyle = modalBody.style.cssText;
                    
                    modalDialog.classList.add('modal-fullscreen');
                    modalDialog.style.transform = 'none';
                    
                    modalBody.style.height = '';
                    modalBody.style.maxHeight = '';
                    
                    maximizeBtn.innerHTML = '◱';
                    maximizeBtn.title = 'Restore';
                    
                    if (modal.dragCleanup) {
                        modal.dragCleanup();
                    }
                    modalHeader.style.cursor = 'default';
                    
                    // Disable body scroll when maximized
                    manageBodyScroll(true);
                    
                    isMaximized = true;
                } else {
                    modalDialog.classList.remove('modal-fullscreen');
                    modalDialog.style.transform = originalTransform;
                    
                    modalBody.style.cssText = originalBodyStyle;
                    
                    maximizeBtn.innerHTML = '□';
                    maximizeBtn.title = 'Maximize';
                    
                    makeModalDraggable(modal, modalHeader, modalDialog);
                    
                    // Re-enable body scroll when restored
                    manageBodyScroll(false);
                    
                    isMaximized = false;
                }
            };

            maximizeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleMaximize();
            });
            
            // Add double-click functionality to modal header
            let clickTimeout;
            modalHeader.addEventListener('click', function(e) {
                // Ignore clicks on buttons
                if (e.target.classList.contains('btn-close') || 
                    e.target.classList.contains('btn-minimize') ||
                    e.target.classList.contains('btn-maximize') ||
                    e.target.closest('.btn-close') ||
                    e.target.closest('.btn-minimize') ||
                    e.target.closest('.btn-maximize')) {
                    return;
                }
                
                if (clickTimeout) {
                    // Double click detected
                    clearTimeout(clickTimeout);
                    clickTimeout = null;
                    toggleMaximize();
                } else {
                    // Single click - set timeout to detect if it's a double click
                    clickTimeout = setTimeout(() => {
                        clickTimeout = null;
                    }, 300); // 300ms window for double click detection
                }
            });
            
            minimizeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                minimizeModal(modal);
            });
        }
        
        makeModalDraggable(modal, modalHeader, modalDialog);
    };
    
    const makeModalDraggable = (modal, modalHeader, modalDialog) => {
        let isDragging = false;
        let currentX;
        let currentY;
        let initialX;
        let initialY;
        let xOffset = 0;
        let yOffset = 0;
        
        modalHeader.style.cssText += `
            cursor: move;
            user-select: none;
        `;
        
        if (!modalDialog.style.transform) {
            modalDialog.style.transform = 'translate(0, 0)';
        }
        
        modalDialog.style.transition = 'none';
        
        const dragStart = (e) => {
            if (e.target.classList.contains('btn-close') || 
                e.target.classList.contains('btn-minimize') ||
                e.target.classList.contains('btn-maximize') ||
                e.target.closest('.btn-close') ||
                e.target.closest('.btn-minimize') ||
                e.target.closest('.btn-maximize')) {
                return;
            }
            
            e.preventDefault();
            
            if (e.type === "touchstart") {
                initialX = e.touches[0].clientX - xOffset;
                initialY = e.touches[0].clientY - yOffset;
            } else {
                initialX = e.clientX - xOffset;
                initialY = e.clientY - yOffset;
            }
            
            if (e.target === modalHeader || modalHeader.contains(e.target)) {
                isDragging = true;
                document.body.style.userSelect = 'none';
            }
        };
        
        const dragEnd = (e) => {
            initialX = currentX;
            initialY = currentY;
            isDragging = false;
            
            document.body.style.userSelect = '';
        };
        
        const drag = (e) => {
            if (isDragging) {
                e.preventDefault();
                
                if (e.type === "touchmove") {
                    currentX = e.touches[0].clientX - initialX;
                    currentY = e.touches[0].clientY - initialY;
                } else {
                    currentX = e.clientX - initialX;
                    currentY = e.clientY - initialY;
                }
                
                xOffset = currentX;
                yOffset = currentY;
                
                modalDialog.style.transform = `translate(${currentX}px, ${currentY}px)`;
            }
        };
        
        // Remove old event listeners if they exist
        if (modal.dragHandlers) {
            modalHeader.removeEventListener('mousedown', modal.dragHandlers.dragStart);
            document.removeEventListener('mousemove', modal.dragHandlers.drag);
            document.removeEventListener('mouseup', modal.dragHandlers.dragEnd);
            modalHeader.removeEventListener('touchstart', modal.dragHandlers.dragStart);
            document.removeEventListener('touchmove', modal.dragHandlers.drag);
            document.removeEventListener('touchend', modal.dragHandlers.dragEnd);
        }
        
        modal.dragHandlers = {
            dragStart,
            drag,
            dragEnd
        };
        
        modalHeader.addEventListener('mousedown', dragStart);
        document.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', dragEnd);
        
        // Touch events
        modalHeader.addEventListener('touchstart', dragStart, { passive: false });
        document.addEventListener('touchmove', drag, { passive: false });
        document.addEventListener('touchend', dragEnd);
        
        // Store cleanup function
        modal.dragCleanup = () => {
            modalHeader.removeEventListener('mousedown', dragStart);
            document.removeEventListener('mousemove', drag);
            document.removeEventListener('mouseup', dragEnd);
            modalHeader.removeEventListener('touchstart', dragStart);
            document.removeEventListener('touchmove', drag);
            document.removeEventListener('touchend', dragEnd);
            delete modal.dragHandlers;
        };
    };
    
    const minimizeModal = (modal) => {
        const modalInstance = bootstrap.Modal.getInstance(modal);
        const modalTitle = modal.querySelector('.modal-title');
        const title = modalTitle ? modalTitle.textContent : 'Modal';
        
        createMinimizeContainer();
        
        minimizedModals.set(modal.id, {
            modal: modal,
            instance: modalInstance,
            wasShown: modal.classList.contains('show'),
            backdrop: modalInstance?._backdrop
        });
        
        // Instead of hiding the modal, just hide it visually. This keeps the modal state and URL intact
        modal.style.display = 'none';
        
        // Hide backdrop if exists
        if (modalInstance && modalInstance._backdrop) {
            modalInstance._backdrop._element.style.display = 'none';
        }
        
        // Remove modal-open class from body and enable scrolling when minimized
        document.body.classList.remove('modal-open');
        manageBodyScroll(false); // Enable body scroll when minimized
        
        // Create minimized panel
        const minimizedPanel = document.createElement('div');
        minimizedPanel.className = 'minimized-modal-panel';
        minimizedPanel.dataset.modalId = modal.id;
        minimizedPanel.style.cssText = `
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 8px 12px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 200px;
            max-width: 300px;
            cursor: pointer;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        `;
        
        // Title
        const titleSpan = document.createElement('span');
        titleSpan.style.cssText = `
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 14px;
            font-weight: 500;
        `;
        titleSpan.textContent = title;
        
        // Maximize button
        const maximizeBtn = document.createElement('button');
        maximizeBtn.type = 'button';
        maximizeBtn.style.cssText = `
            background: none;
            border: none;
            padding: 4px 8px;
            cursor: pointer;
            font-size: 18px;
            line-height: 1;
            color: #6c757d;
            transition: color 0.15s;
        `;
        maximizeBtn.innerHTML = '□';
        maximizeBtn.title = 'Maximize';
        
        maximizeBtn.addEventListener('mouseenter', function() {
            this.style.color = '#000';
        });
        
        maximizeBtn.addEventListener('mouseleave', function() {
            this.style.color = '#6c757d';
        });
        
        maximizeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            restoreModal(modal.id);
        });
        
        // Close button
        const closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.style.cssText = `
            background: none;
            border: none;
            padding: 4px 8px;
            cursor: pointer;
            font-size: 18px;
            line-height: 1;
            color: #6c757d;
            transition: color 0.15s;
        `;
        closeBtn.innerHTML = '×';
        closeBtn.title = 'Close';
        
        closeBtn.addEventListener('mouseenter', function() {
            this.style.color = '#000';
        });
        
        closeBtn.addEventListener('mouseleave', function() {
            this.style.color = '#6c757d';
        });
        
        closeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Restore modal visibility temporarily to properly close it
            modal.style.display = '';
            if (modalInstance && modalInstance._backdrop) {
                modalInstance._backdrop._element.style.display = '';
            }
            
            // Properly close the modal using Bootstrap's method
            if (modalInstance) {
                modalInstance.hide();
            }
            
            // Remove from minimized modals
            minimizedModals.delete(modal.id);
            minimizedPanel.remove();
            minimizedCount--;
            
            // Reset draggable state
            modal.dataset.draggableInitialized = 'false';
            
            // Remove container if empty
            if (minimizedCount === 0) {
                const container = document.getElementById('minimized-modals-container');
                if (container && container.children.length === 0) {
                    container.remove();
                }
            }
        });
        
        // Assemble panel
        minimizedPanel.appendChild(titleSpan);
        minimizedPanel.appendChild(maximizeBtn);
        minimizedPanel.appendChild(closeBtn);
        
        // Add click to restore
        minimizedPanel.addEventListener('click', function(e) {
            if (e.target === maximizeBtn || e.target === closeBtn) return;
            restoreModal(modal.id);
        });
        
        // Add hover effect
        minimizedPanel.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
        });
        
        minimizedPanel.addEventListener('mouseleave', function() {
            this.style.boxShadow = '0 2px 5px rgba(0,0,0,0.15)';
        });
        
        document.getElementById('minimized-modals-container').appendChild(minimizedPanel);
        minimizedCount++;
    };
    
    // Restore modal
    const restoreModal = (modalId) => {
        const modalData = minimizedModals.get(modalId);
        if (!modalData) return;
        
        const { modal, instance, backdrop } = modalData;
        
        // Remove minimized panel
        const panel = document.querySelector(`[data-modal-id="${modalId}"]`);
        if (panel) panel.remove();
        
        // Restore modal visibility
        modal.style.display = 'block';
        
        // Restore backdrop
        if (instance && instance._backdrop && instance._backdrop._element) {
            instance._backdrop._element.style.display = 'block';
        }
        
        // Restore body classes and manage scroll based on modal state
        document.body.classList.add('modal-open');
        const isMaximized = modal.querySelector('.modal-fullscreen');
        manageBodyScroll(isMaximized ? true : false);
        
        // Ensure modal has proper display classes
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        modal.setAttribute('aria-modal', 'true');
        modal.style.paddingRight = '';
        
        minimizedModals.delete(modalId);
        minimizedCount--;
        
        // Remove container if empty
        if (minimizedCount === 0) {
            const container = document.getElementById('minimized-modals-container');
            if (container && container.children.length === 0) {
                container.remove();
            }
        }
    };
    
    // Initialize existing modals with draggable-modal attribute
    document.querySelectorAll('.modal[draggable-modal]').forEach(modal => {
        // Ensure modal has an ID
        if (!modal.id) {
            modal.id = 'modal-' + Math.random().toString(36).substr(2, 9);
        }
        
        // Initialize when modal is shown
        modal.addEventListener('shown.bs.modal', function() {
            initializeModal(this);
        });
        
        // Cleanup when modal is hidden but reset initialization flag
        modal.addEventListener('hidden.bs.modal', function() {
            if (this.dragCleanup) {
                this.dragCleanup();
            }
            // Reset the initialization flag so it can be re-initialized
            this.dataset.draggableInitialized = 'false';
            
            // Re-enable body scroll when modal is closed
            manageBodyScroll(false);
        });
    });
    
    // Watch for dynamically added modals
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1) {
                    if (node.classList && node.classList.contains('modal') && node.hasAttribute('draggable-modal')) {
                        if (!node.id) {
                            node.id = 'modal-' + Math.random().toString(36).substr(2, 9);
                        }
                        
                        node.addEventListener('shown.bs.modal', function() {
                            initializeModal(this);
                        });
                        
                        node.addEventListener('hidden.bs.modal', function() {
                            if (this.dragCleanup) {
                                this.dragCleanup();
                            }
                            // Reset the initialization flag
                            this.dataset.draggableInitialized = 'false';
                            
                            // Re-enable body scroll when modal is closed
                            manageBodyScroll(false);
                        });
                    } else if (node.querySelector) {
                        const modals = node.querySelectorAll('.modal[draggable-modal]');
                        modals.forEach(modal => {
                            if (!modal.id) {
                                modal.id = 'modal-' + Math.random().toString(36).substr(2, 9);
                            }
                            
                            modal.addEventListener('shown.bs.modal', function() {
                                initializeModal(this);
                            });
                            
                            modal.addEventListener('hidden.bs.modal', function() {
                                if (this.dragCleanup) {
                                    this.dragCleanup();
                                }
                                // Reset the initialization flag
                                this.dataset.draggableInitialized = 'false';
                                
                                // Re-enable body scroll when modal is closed
                                manageBodyScroll(false);
                            });
                        });
                    }
                }
            });
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});