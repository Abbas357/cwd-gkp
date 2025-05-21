function cwButtons() {
    const buttons = document.querySelectorAll(".cw-btn");

    buttons.forEach((button) => {
        const iconClass = button.getAttribute("data-icon");
        if (iconClass) {
            button.innerHTML = `<i class="${iconClass}"></i>${button.textContent.trim()}`;
        }
    });
}

function loadZuckLibraries(callback) {
    if (!document.getElementById("zuck-css")) {
        let cssLink = document.createElement("link");
        cssLink.id = "zuck-css";
        cssLink.rel = "stylesheet";
        cssLink.href = "/site/lib/zuck/css/zuck.min.css";
        document.head.appendChild(cssLink);
    }

    if (!document.getElementById("zuck-js")) {
        let scriptTag = document.createElement("script");
        scriptTag.id = "zuck-js";
        scriptTag.src = "/site/lib/zuck/js/zuck.min.js";
        scriptTag.onload = callback;
        document.body.appendChild(scriptTag);
    } else {
        callback();
    }
}

function formValidation() {
    document.querySelectorAll('.needs-validation').forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                setButtonLoading(
                    form.querySelector(
                        'button[type="submit"], input[type="submit"]'
                    )
                );
            }
            
            form.classList.add('was-validated');
        }, false);
        
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
}

function loadStories() {
    let btn = document.querySelector("#view-stories");
    let contentSeenItems = JSON.parse(
        localStorage.getItem("zuck-stories-content-seenItems") || "{}"
    );
    let seenUserIds = Object.keys(contentSeenItems);

    fetch("/stories", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ seenUserIds }),
    })
        .then((response) => {
            if (!response.ok) {
                return null;
            }
            return response.json();
        })
        .then((data) => {
            if (!data) {
                btn.classList.remove("stories-indicator");
                return;
            }

            if (data.success && Array.isArray(data.data?.result)) {
                let storiesData = data.data.result;

                if (
                    Array.isArray(data.expiredUsers) &&
                    data.expiredUsers.length > 0
                ) {
                    data.expiredUsers.forEach((userId) => {
                        delete contentSeenItems[userId];
                    });
                    localStorage.setItem(
                        "zuck-stories-content-seenItems",
                        JSON.stringify(contentSeenItems)
                    );
                }

                let unviewedSeenItems = JSON.parse(
                    localStorage.getItem("zuck-unviewed-stories-seenItems") ||
                        "{}"
                );

                storiesData.sort((a, b) => {
                    let aViewed =
                        unviewedSeenItems[a.id] ||
                        contentSeenItems[a.id] ||
                        false;
                    let bViewed =
                        unviewedSeenItems[b.id] ||
                        contentSeenItems[b.id] ||
                        false;

                    return aViewed === bViewed ? 0 : aViewed ? 1 : -1;
                });

                if (storiesData.some((story) => !contentSeenItems[story.id])) {
                    btn.classList.add("stories-indicator");
                } else {
                    btn.classList.remove("stories-indicator");
                }
            } else {
                btn.classList.remove("stories-indicator");
            }
        })
        .catch((error) => {
            console.warn("No stories or server error occurred:", error);
            btn.classList.remove("stories-indicator");
        });

    document
        .querySelector("#view-stories")
        .addEventListener("click", function (e) {
            let btn = document.querySelector("#view-stories");
            if (btn.classList.contains("stories-indicator")) {
                btn.classList.remove("stories-indicator");
            }
            let storiesContent = document.querySelector("#stories-content");
            let spinner = document.querySelector("#stories-spinner");
            let errorMessage =
                "<div class='alert alert-warning' role='alert' style='margin-bottom:0px'>There are currently no stories</div>";

            loadZuckLibraries(function () {
                storiesContent.classList.remove("d-none");
                spinner.classList.add("show");

                let contentSeenItems = localStorage.getItem(
                    "zuck-stories-content-seenItems"
                );
                contentSeenItems = contentSeenItems
                    ? JSON.parse(contentSeenItems)
                    : {};

                let seenUserIds = Object.keys(contentSeenItems);

                fetch("/stories", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({
                        seenUserIds: seenUserIds,
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        spinner.classList.remove("show");
                        if (data.success) {
                            let storiesData = data.data.result;

                            if (
                                data.expiredUsers &&
                                data.expiredUsers.length > 0
                            ) {
                                data.expiredUsers.forEach((userId) => {
                                    delete contentSeenItems[userId];
                                });
                                localStorage.setItem(
                                    "zuck-stories-content-seenItems",
                                    JSON.stringify(contentSeenItems)
                                );
                            }

                            storiesContent.innerHTML = "";

                            let unviewedSeenItems = localStorage.getItem(
                                "zuck-unviewed-stories-seenItems"
                            );
                            contentSeenItems = localStorage.getItem(
                                "zuck-stories-content-seenItems"
                            );

                            unviewedSeenItems = unviewedSeenItems
                                ? JSON.parse(unviewedSeenItems)
                                : {};
                            contentSeenItems = contentSeenItems
                                ? JSON.parse(contentSeenItems)
                                : {};

                            storiesData.sort((a, b) => {
                                let aViewed =
                                    unviewedSeenItems[a.id] ||
                                    contentSeenItems[a.id] ||
                                    false;
                                let bViewed =
                                    unviewedSeenItems[b.id] ||
                                    contentSeenItems[b.id] ||
                                    false;

                                if (aViewed && !bViewed) return 1;
                                if (!aViewed && bViewed) return -1;
                                return 0;
                            });
                            const zuckInstance = new Zuck(storiesContent, {
                                backNative: true,
                                autoFullScreen: false,
                                skin: "snapgram",
                                avatars: true,
                                list: false,
                                cubeEffect: true,
                                localStorage: true,
                                reactive: false,
                                stories: storiesData,
                                callbacks: {
                                    onView: function (storyId, callback) {
                                        incrementViewCount(storyId);
                                        if (typeof callback === "function") {
                                            callback();
                                        }
                                    },
                                    onClose: function (storyId, callback) {
                                        callback();
                                    },
                                    onOpen: function (storyId, callback) {
                                        callback();
                                    },
                                    onNextItem: function (
                                        storyId,
                                        currentItem,
                                        callback
                                    ) {
                                        callback();
                                    },
                                    onEnd: function (storyId, callback) {
                                        callback();
                                    },
                                    onNavigateItem: function (
                                        storyId,
                                        direction,
                                        callback
                                    ) {
                                        callback();
                                    },
                                    onDataUpdate: function (storyId, callback) {
                                        callback();
                                    },
                                },
                            });

                            storiesContent.zuckInstance = zuckInstance;

                            function incrementViewCount(storyId) {
                                fetch(`/stories/viewed/${storyId}`, {
                                    method: "PATCH",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": document
                                            .querySelector(
                                                'meta[name="csrf-token"]'
                                            )
                                            .getAttribute("content"),
                                    },
                                }).then((response) => response.json());
                            }
                        } else {
                            storiesContent.innerHTML = errorMessage;
                        }
                    })
                    .catch((error) => {
                        spinner.classList.remove("show");
                        storiesContent.innerHTML = errorMessage;
                    });
            });
        });

    document
        .querySelector("#storiesCanvas")
        .addEventListener("hidden.bs.offcanvas", function () {
            let storiesContent = document.querySelector("#stories-content");

            storiesContent.innerHTML = `
        <div id="stories-spinner" class="show bg-white d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
            storiesContent.classList.add("d-none");
        });
}

function loadNotification() {
    const notificationContainer = document.getElementById("notification-container");
    let currentPage = 1;
    let isLoading = false;
    let hasMorePages = true;

    const notificationsSeen = sessionStorage.getItem("notifications_seen");

    notificationContainer.innerHTML = `
        <div id="news-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="background: #ffffffdd">
                    <div class="modal-header" style="background-color: #ff660010 !important">
                        <h5 class="modal-title"><i class="bi-megaphone"></i> &nbsp; Notifications</h5>
                        <button type="button" class="btn-close border border-2 border-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center mb-1" style="margin-top:-4px">
                            <div class="flex-grow-1 me-3">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" id="search-notifications" class="form-control" style="border-radius: 3px; padding: .4rem .8rem" placeholder="Search..." />
                                </div>
                            </div>
                            <div>
                                <select id="filter-notifications" class="form-select" style="border-radius: 3px; padding: .4rem .8rem; min-width: 150px;">
                                    <option value="">All</option>
                                    <option value="Tender">Tenders</option>
                                    <option value="Gallery">Galleries</option>
                                    <option value="Event">Events</option>
                                    <option value="News">News</option>
                                    <option value="Seniority">Seniorities</option>
                                </select>
                            </div>
                        </div>
                        <div id="modal-body-content" class="custom-scrollbar" style="height: 400px; overflow-y: auto;">
                            <div id="notification-list"></div>
                            <div id="loading-indicator" class="d-flex justify-content-center my-3">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center w-100" style="padding: 2px !important; background-color: #ff660010 !important">
                        <div><a href="/notifications/all">All Notifications</a></div>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.addEventListener("DOMContentLoaded", () => {
        const scrollableElements =
            document.querySelectorAll(".custom-scrollbar");

        scrollableElements.forEach((element) => {
            let timeout;

            element.addEventListener("mouseenter", () => {
                clearTimeout(timeout);
                element.style.scrollbarWidth = "thin";
                element.style.scrollbarColor = "rgba(0, 0, 0, 0.2) transparent";
            });

            element.addEventListener("mouseleave", () => {
                timeout = setTimeout(() => {
                    element.style.scrollbarWidth = "none";
                    element.style.scrollbarColor = "transparent transparent";
                }, 1000);
            });

            const contentWidth = element.offsetWidth;
            element.style.width = `${contentWidth}px`;
        });
    });

    const newsModal = new bootstrap.Modal(
        document.getElementById("news-modal")
    );
    const notificationList = document.getElementById("notification-list");
    const loadingIndicator = document.getElementById("loading-indicator");
    const modalBodyContent = document.getElementById("modal-body-content");
    const searchInput = document.getElementById("search-notifications");
    const filterDropdown = document.getElementById("filter-notifications");

    searchInput.addEventListener("input", handleSearchOrFilter);
    filterDropdown.addEventListener("change", handleSearchOrFilter);

    function handleSearchOrFilter() {
        currentPage = 1;
        notificationList.innerHTML = "";
        loadingIndicator.innerHTML = `<div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>`;
        hasMorePages = true;
        fetchNotifications(currentPage);
    }

    if (!notificationsSeen) {
        fetchNotifications(currentPage);
        newsModal.show();
    }

    function fetchNotifications(page) {
        if (isLoading || !hasMorePages) return;

        isLoading = true;
        const searchQuery = searchInput.value.trim();
        const selectedType = filterDropdown.value;
        showLoadingIndicator(true);

        fetch(
            `/notifications?page=${page}&search=${encodeURIComponent(
                searchQuery
            )}&type=${selectedType}`
        )
            .then((response) => response.json())
            .then((data) => {
                const { notifications, nextPage, hasMore } = data;

                if (notifications.length) {
                    appendNotifications(notifications);
                }

                currentPage = nextPage || currentPage;
                hasMorePages = hasMore;
                isLoading = false;
                sessionStorage.setItem("notifications_seen", true);

                if (!hasMore) {
                    showLoadingIndicator(false);
                    displayEndOfNotificationsMessage();
                }
            })
            .catch((error) => {
                console.error("Error fetching notifications:", error);
                isLoading = false;
                showLoadingIndicator(false);
            });
    }

    function appendNotifications(notifications) {
        const notificationItems = notifications
            .map(
                (item) => `
            <div class="d-flex align-items-center p-2 notification-item ${
                item.recentNotification && "recent-notification-indicator"
            }">
                <div class="me-3 notification-img">
                    <img src="${
                        item.imageUrl
                    }" class="img-fluid rounded}" alt="${item.type}">
                </div>
                <div class="flex-grow-1">
                    <a href="${item.url}">${item.title}</a>
                </div>
                <small class="news-date text-muted d-flex flex-column align-items-end ms-2" style="flex-shrink: 0;">
                    <div class="mb-1">
                        <a href="${
                            item.info[2]
                        }" class="badge text-bg-primary" style="font-size: 10px; display: inline-block">${
                    item.info[0]
                }</a>
                    </div>
                    <span class="fw-bold" style="font-size:.7rem">${
                        item.created_at
                    }</span>
                </small>
            </div>
        `
            )
            .join("");

        notificationList.innerHTML += notificationItems;
    }

    function showLoadingIndicator(show) {
        loadingIndicator.style.display = show ? "flex" : "none";
    }

    function displayEndOfNotificationsMessage() {
        loadingIndicator.innerHTML = `
            <span class="text-muted">No more notifications</span>
        `;
    }

    modalBodyContent.addEventListener("scroll", () => {
        if (
            modalBodyContent.scrollTop + modalBodyContent.clientHeight >=
            modalBodyContent.scrollHeight - 50
        ) {
            fetchNotifications(currentPage);
        }
    });
}

function loadAnnouncement() {
    const announcementContainer = document.getElementById("announcement-container");
    let isLoading = true;

    const announcementSeen = sessionStorage.getItem("announcement_seen");

    let loadingIndicator = document.getElementById("loading-indicator");
    if (!loadingIndicator) {
        loadingIndicator = document.createElement("div");
        loadingIndicator.id = "loading-indicator";
        loadingIndicator.className = "d-flex justify-content-center my-3";
        loadingIndicator.innerHTML = `
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        `;
        announcementContainer.appendChild(loadingIndicator);
    }

    if (!announcementSeen) {
        fetchAnnouncement();
    }

    function fetchAnnouncement() {
        showLoadingIndicator(true);
        
        fetch(`/announcement`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then((announcement) => {
                showLoadingIndicator(false);
                
                if (!announcement || !announcement.title || !announcement.slug) {
                    console.log("No valid announcement data available");
                    return;
                }
                
                announcementContainer.innerHTML = `
                    <div id="announcement-modal" class="modal zoomin" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document"  style="width: 80vw">
                            <div class="modal-content p-0 m-0 border border-2 border-warning shadow-lg">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title"><i class="bi-megaphone"></i> &nbsp; ${announcement.title}</h5>
                                    <button type="button" class="btn-close border border-2 border-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0 m-0">
                                    <a href="/news/${announcement.slug}" class="d-block">
                                        <img src="${announcement.image || ''}" class="img-fluid rounded" alt="${announcement.title}" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                try {
                    const announcementModal = new bootstrap.Modal(document.getElementById("announcement-modal"));
                    announcementModal.show();
                
                    isLoading = false;
                    sessionStorage.setItem("announcement_seen", true);
                } catch (error) {
                    console.error("Error showing announcement modal:", error);
                }
            })
            .catch((error) => {
                console.error("Error fetching announcement:", error);
                isLoading = false;
                showLoadingIndicator(false);
            });
    }

    function showLoadingIndicator(show) {
        if (loadingIndicator) {
            loadingIndicator.style.display = show ? "flex" : "none";
        }
    }
}

function customTheme() {
    const offcanvas = document.createElement("div");
    offcanvas.className = "offcanvas offcanvas-end";
    offcanvas.id = "themeCanvas";
    offcanvas.setAttribute("tabindex", "-1");
    offcanvas.setAttribute("aria-labelledby", "themeCanvasLabel");

    const themeOptions = [
        {
            name: "default",
            color: "#0b7240",
            title: "Default Theme",
        },
        {
            name: "brown",
            color: "#855723",
            title: "Brown Theme",
        },
        {
            name: "blue",
            color: "#3b5998",
            title: "Blue Theme",
        },
        {
            name: "violet",
            color: "#612bac",
            title: "Violet Theme",
        },
        {
            name: "darkred",
            color: "#830051",
            title: "Dark Red Theme",
        },
    ];

    offcanvas.innerHTML = `
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="themeCanvasLabel">Choose Theme</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-flex flex-column gap-3">
                ${themeOptions
                    .map(
                        (theme) => `
                    <div class="theme-option p-3 rounded" onclick="applyTheme('${theme.name}')" 
                        style="cursor: pointer; border: 1px solid #ddd; box-shadow: 0 0 15px #00000045" onmouseover="this.style.backgroundColor='${theme.color}'; this.style.color = 'white'" onmouseout="this.style.backgroundColor='transparent'; this.style.color = 'black'">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 25px; height: 25px; background-color: ${theme.color}; border-radius: 50%;border:2px solid #fff;"></div>
                            <h6 class="mb-0">${theme.title}</h6>
                        </div>
                    </div>
                `
                    )
                    .join("")}
            </div>
        </div>
    `;

    document.body.appendChild(offcanvas);

    window.applyTheme = function (themeName) {
        let themeLink = document.getElementById("theme-stylesheet");

        if (themeName === "default") {
            if (themeLink) {
                themeLink.remove();
            }
        } else {
            if (!themeLink) {
                themeLink = document.createElement("link");
                themeLink.id = "theme-stylesheet";
                themeLink.rel = "stylesheet";
                const styleSheet = document.querySelector(
                    'link[href*="style.min.css"]'
                );
                if (styleSheet) {
                    styleSheet.parentNode.insertBefore(
                        themeLink,
                        styleSheet.nextSibling
                    );
                } else {
                    document.head.appendChild(themeLink);
                }
            }
            themeLink.href = `/site/css/themes/${themeName}.css`;
        }

        localStorage.setItem("selectedTheme", themeName);
        window.themeCanvas.hide();
    };

    window.themeCanvas = new bootstrap.Offcanvas(
        document.getElementById("themeCanvas")
    );
}

document.addEventListener("DOMContentLoaded", (e) => {
    formValidation();
    loadStories();
    loadNotification();
    loadAnnouncement();
    customTheme();
    cwButtons();
});

