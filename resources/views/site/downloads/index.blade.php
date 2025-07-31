<x-main-layout title="All Downloads">
    @push('style')
        <style>
            /* Updated CSS for sticky positioning on both sidebar and main content */

            .nav-pills .nav-link {
                color: #495057;
                border-radius: 0;
                transition: all 0.3s ease;
            }

            .nav-pills .nav-link:hover {
                background-color: #e9ecef;
            }

            .nav-pills .nav-link.active {
                background-color: #575757;
                color: white;
            }

            .download-tabs .nav-link {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 1rem;
                border-bottom: 1px solid #dee2e6;
            }

            /* Sidebar sticky positioning */
            .download-sidebar {
                position: sticky;
                top: 4rem;
                height: fit-content;
                /* Ensures proper sticky behavior */
            }

            /* Main content sticky positioning */
            .downloads-main-content {
                position: sticky;
                top: 4rem;
                height: fit-content;
                /* Ensures proper sticky behavior */
            }

            .tabs-container {
                max-height: 400px;
                overflow-y: auto;
                scrollbar-width: thin;
            }

            .tabs-container::-webkit-scrollbar {
                width: 5px;
            }

            .tabs-container::-webkit-scrollbar-thumb {
                background-color: #c1c1c1;
                border-radius: 10px;
            }

            @media (max-width: 767.98px) {
                .offcanvas-downloads {
                    z-index: 1050;
                }

                .category-toggle-btn {
                    position: fixed;
                    top: 8rem;
                    left: 0px;
                    z-index: 999;
                    border-radius: 5px;
                    width: 35px;
                    height: 35px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
                }

                .category-toggle-btn::before {
                    content: '';
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    width: 100%;
                    height: 100%;
                    border-radius: 5px;
                    animation: ripple .5s cubic-bezier(0.895, 0.03, 0.685, 0.22) infinite;
                    pointer-events: none;
                }

                @keyframes ripple {
                    0% {
                        box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.2);
                    }

                    100% {
                        box-shadow: 0 0 0 10px rgba(0, 0, 0, 0);
                    }
                }

                /* Remove sticky positioning on mobile for better UX */
                .download-sidebar,
                .downloads-main-content {
                    position: static;
                }
            }

            .file-icon {
                font-size: 1.2rem;
                vertical-align: middle;
            }

            .app-item:hover {
                transform: translateY(-8px);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
                border-color: #10b981 !important;
            }

            .app-icon {
                transition: transform 0.3s ease;
                box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
            }

            .app-item:hover .app-icon {
                transform: scale(1.05);
            }

            .btn-success {
                background: linear-gradient(135deg, #10b981, #059669);
                border: none;
            }

            .btn-success:hover {
                background: linear-gradient(135deg, #059669, #047857);
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
            }
        </style>
    @endpush

    <x-slot name="breadcrumbTitle">
        Downloads
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Downloads</li>
    </x-slot>
    <div class="container my-4">
        <div class="row g-4">
            <div class="d-md-none d-block">
                <button class="btn btn-light border border-secondary category-toggle-btn shadow" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#categoriesOffcanvas">
                    <i class="bi bi-list"></i>
                </button>
            </div>

            <div class="col-md-3 d-none d-md-block" style="">
                <div class="download-sidebar">
                    <div class="card border-0 shadow-sm overflow-hidden">
                        <div class="card-header bg-light border p-3">
                            <h5 class="m-0 fw-bold"><i class="bi bi-folder me-2"></i>Categories</h5>
                        </div>
                        <div class="mt-2">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="categorySearch"
                                    placeholder="Search categories..." aria-label="Search categories">
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column download-tabs" id="categoryTabs" role="tablist">
                                @foreach ($categories as $category)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="tab-{{ Str::slug($category) }}"
                                            data-category="{{ $category }}" data-bs-toggle="tab"
                                            href="#{{ Str::slug($category) }}" role="tab"
                                            aria-controls="{{ Str::slug($category) }}" aria-selected="false">
                                            <span>
                                                <i class="bi bi-folder2-open me-2"></i>{{ $category }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Off-canvas Categories for mobile -->
            <div class="offcanvas offcanvas-start offcanvas-downloads" tabindex="-1" id="categoriesOffcanvas"
                aria-labelledby="categoriesOffcanvasLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="categoriesOffcanvasLabel">
                        <i class="bi bi-folder me-2"></i>Download Categories
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <div class="mt-2 w-100">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="mobileCategorySearch"
                                placeholder="Search categories..." aria-label="Search categories">
                        </div>
                    </div>
                    <ul class="nav nav-pills flex-column download-tabs" id="mobileCategoryTabs" role="tablist">
                        @foreach ($categories as $category)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="mobile-tab-{{ Str::slug($category) }}"
                                    data-category="{{ $category }}" data-bs-toggle="tab"
                                    href="#{{ Str::slug($category) }}" role="tab"
                                    aria-controls="{{ Str::slug($category) }}" aria-selected="false"
                                    data-bs-dismiss="offcanvas">
                                    <span>
                                        <i class="bi bi-folder2-open me-2"></i> {{ $category }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Downloads Content -->
            <div class="col-md-9">
                <div class="downloads-main-content border border-light shadow-sm">
                    <div class="tab-content" id="categoryTabContent">
                        @foreach ($categories as $category)
                            <div id="{{ Str::slug($category) }}" class="tab-pane fade">
                                <!-- All tabs start with a loading spinner -->
                                <div class="download-loader text-center p-4">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2">Loading downloads...</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const offcanvasElement = document.getElementById('categoriesOffcanvas');
                const mobileTabLinks = document.querySelectorAll('#mobileCategoryTabs .nav-link');
                const offcanvasInstance = offcanvasElement ? new bootstrap.Offcanvas(offcanvasElement) : null;
                let isInitialLoad = true;

                mobileTabLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (offcanvasInstance) {
                            offcanvasInstance.hide();
                        }
                    });
                });

                const categoryTabs = document.querySelectorAll('[data-category]');

                const loadTabContent = (tab) => {
                    const category = tab.getAttribute('data-category');
                    const tabPaneId = tab.getAttribute('href').substring(1);
                    const tabPane = document.getElementById(tabPaneId);

                    if (tabPane && tabPane.querySelector('.card') && !tabPane.querySelector('.spinner-border')) {
                        return;
                    }

                    const url = "{{ route('downloads.fetch-category') }}";
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                category
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            const wrapper = document.createElement('div');
                            wrapper.innerHTML = data.downloads;

                            const cardHtml = `
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light border-0 py-3">
                                <h5 class="m-0">
                                    <i class="bi bi-folder2-open me-2"></i>
                                    ${category} Downloads
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    ${wrapper.querySelector('table').outerHTML}
                                </div>
                            </div>
                        </div>
                    `;

                            tabPane.innerHTML = cardHtml;
                        })
                        .catch(error => {
                            console.error('Error fetching category:', error);
                            tabPane.innerHTML =
                                '<div class="p-4 text-center text-danger">Failed to load content. Please try again.</div>';
                        });
                };

                function activateTab(tabId, updateUrl = true) {
                    const desktopTab = document.querySelector(`#categoryTabs .nav-link[href="#${tabId}"]`);
                    const mobileTab = document.querySelector(`#mobileCategoryTabs .nav-link[href="#${tabId}"]`);
                    const tabs = [desktopTab, mobileTab].filter(tab => tab !== null);

                    if (tabs.length === 0) return false;

                    document.querySelectorAll('.nav-link').forEach(t => {
                        t.classList.remove('active');
                        t.setAttribute('aria-selected', 'false');
                    });

                    document.querySelectorAll('.tab-pane').forEach(p => {
                        p.classList.remove('show', 'active');
                    });

                    tabs.forEach(t => {
                        t.classList.add('active');
                        t.setAttribute('aria-selected', 'true');
                    });

                    const tabPane = document.getElementById(tabId);
                    if (tabPane) {
                        tabPane.classList.add('show', 'active');
                    }

                    loadTabContent(tabs[0]);

                    if (updateUrl) {
                        history.pushState(null, null, '#' + tabId);
                    }

                    return true;
                }

                categoryTabs.forEach(tab => {
                    tab.addEventListener('click', (e) => {
                        e.preventDefault();
                        const tabId = tab.getAttribute('href').substring(1);
                        activateTab(tabId);
                    });
                });

                function handleInitialTabState() {
                    if (window.location.hash) {
                        const hash = window.location.hash.substring(1);
                        if (!activateTab(hash, false)) {
                            const firstTab = document.querySelector('#categoryTabs .nav-link');
                            if (firstTab) {
                                const firstTabId = firstTab.getAttribute('href').substring(1);
                                activateTab(firstTabId, false);
                            }
                        }
                    } else {
                        const firstTab = document.querySelector('#categoryTabs .nav-link');
                        if (firstTab) {
                            const firstTabId = firstTab.getAttribute('href').substring(1);
                            activateTab(firstTabId, false);
                        }
                    }
                    isInitialLoad = false;
                }

                window.addEventListener('popstate', () => {
                    if (window.location.hash) {
                        const hash = window.location.hash.substring(1);
                        activateTab(hash, false);
                    } else {
                        const firstTab = document.querySelector('#categoryTabs .nav-link');
                        if (firstTab) {
                            const firstTabId = firstTab.getAttribute('href').substring(1);
                            activateTab(firstTabId, false);
                        }
                    }
                });

                handleInitialTabState();

                const categorySearch = document.getElementById('categorySearch');
                if (categorySearch) {
                    categorySearch.addEventListener('input', function() {
                        filterTabs('categoryTabs', this.value.toLowerCase());
                    });
                }

                const mobileCategorySearch = document.getElementById('mobileCategorySearch');
                if (mobileCategorySearch) {
                    mobileCategorySearch.addEventListener('input', function() {
                        filterTabs('mobileCategoryTabs', this.value.toLowerCase());
                    });
                }

                function filterTabs(tabsId, searchTerm) {
                    const tabsList = document.getElementById(tabsId);
                    if (!tabsList) return;

                    const tabs = tabsList.querySelectorAll('.nav-item');
                    let foundAny = false;

                    tabs.forEach(tab => {
                        const tabLink = tab.querySelector('.nav-link');
                        const tabText = tabLink.textContent.toLowerCase();

                        if (tabText.includes(searchTerm)) {
                            tab.style.display = '';
                            foundAny = true;
                        } else {
                            tab.style.display = 'none';
                        }
                    });

                    let noResultsMsg = tabsList.querySelector('.no-results-message');

                    if (!foundAny) {
                        if (!noResultsMsg) {
                            noResultsMsg = document.createElement('li');
                            noResultsMsg.className = 'nav-item no-results-message';
                            noResultsMsg.innerHTML = '<div class="p-3 text-muted">No matching categories found</div>';
                            tabsList.appendChild(noResultsMsg);
                        }
                    } else if (noResultsMsg) {
                        noResultsMsg.remove();
                    }
                }
            });
        </script>
    @endpush
</x-main-layout>
