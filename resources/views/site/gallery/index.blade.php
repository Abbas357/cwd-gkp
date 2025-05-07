<x-main-layout title="Gallery">

    @push('style')
    <style>
        .gallery-wrapper {
            background-color: #f8f9fa;
        }
        
        .gallery-nav .nav-link {
            color: #495057;
            border-radius: 0;
            transition: all 0.3s ease;
        }
        
        .gallery-nav .nav-link:hover {
            background-color: #e9ecef;
        }
        
        .gallery-nav .nav-link.active {
            background-color: #575757;
            color: white;
        }
        
        .hover-card {
            transition: all 0.3s ease;
        }
        
        .hover-card:hover {
            transform: translateY(-5px);
        }
        
        .gallery-image {
            overflow: hidden;
        }
        
        .transition {
            transition: all 0.5s ease;
        }
        
        .gallery-image img:hover {
            transform: scale(1.05);
        }
        
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.2);
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .gallery-image:hover .gallery-overlay {
            opacity: 1;
        }
        
        .object-fit-cover {
            object-fit: cover;
        }
        
        #gallery-loader {
            display: none;
            text-align: center;
            padding: 30px;
        }
        
        /* New styles for list view */
        .list-view .gallery-item .card {
            flex-direction: row;
        }
        
        .list-view .gallery-item .gallery-image {
            width: 30%;
            min-width: 200px;
        }
        
        .list-view .gallery-item .card-body {
            width: 70%;
        }
        
        .list-view .gallery-item .card-footer {
            display: none;
        }
        
        .list-view .gallery-item .list-view-btn {
            display: inline-block !important;
        }
        
        @media (max-width: 767.98px) {
            .list-view .gallery-item .card {
                flex-direction: column;
            }
            
            .list-view .gallery-item .gallery-image,
            .list-view .gallery-item .card-body {
                width: 100%;
            }
            
            .offcanvas-categories {
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
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
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
                    box-shadow: 0 0 0 0 rgba(0,0,0,0.2);
                }
                100% {
                    box-shadow: 0 0 0 10px rgba(0,0,0,0);
                }
            }
        }
    </style>
    @endpush
    <x-slot name="breadcrumbTitle">
        <span>Gallery</span>
    </x-slot>
    
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Gallery</li>
    </x-slot>
    
    <div class="gallery-wrapper my-4">
        <div class="container">
            
            <div class="row g-4">
                <!-- Mobile Categories Button (visible on small screens) -->
                <div class="d-lg-none d-block">
                    <button class="btn btn-light border border-secondary category-toggle-btn shadow" type="button" data-bs-toggle="offcanvas" data-bs-target="#categoriesOffcanvas">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
                
                <!-- Sidebar with Categories (Hidden on mobile) -->
                <div class="col-lg-3 col-md-4 d-none d-md-block">
                    <div class="category-sidebar position-sticky" style="top: 4rem;">
                        <div class="card border-0 shadow-sm overflow-hidden">
                            <div class="card-header bg-light border p-3">
                                <h5 class="m-0 fw-bold"><i class="bi bi-layers me-2"></i>Categories</h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="nav nav-pills flex-column gallery-nav" id="galleryTabs" role="tablist">
                                    @foreach ($galleryTypes as $type)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link d-flex justify-content-between align-items-center py-3 px-4 border-bottom" 
                                               id="tab-{{ Str::slug($type) }}" 
                                               data-bs-toggle="tab" 
                                               href="#{{ Str::slug($type) }}" 
                                               role="tab" 
                                               data-type="{{ $type }}"
                                               aria-controls="{{ Str::slug($type) }}" 
                                               aria-selected="false">
                                                <span><i class="bi bi-folder me-2"></i>{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                                                <span class="gallery-count-{{ Str::slug($type) }}">
                                                    {{ $galleryCounts[$type] ?? 0 }}
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
                <div class="offcanvas offcanvas-start offcanvas-categories" tabindex="-1" id="categoriesOffcanvas" aria-labelledby="categoriesOffcanvasLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="categoriesOffcanvasLabel">
                            <i class="bi bi-layers me-2"></i>Gallery Categories
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body p-0">
                        <ul class="nav nav-pills flex-column gallery-nav" id="mobileGalleryTabs" role="tablist">
                            @foreach ($galleryTypes as $type)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link d-flex justify-content-between align-items-center py-3 px-4 border-bottom" 
                                       id="mobile-tab-{{ Str::slug($type) }}" 
                                       data-bs-toggle="tab" 
                                       href="#{{ Str::slug($type) }}" 
                                       role="tab" 
                                       data-type="{{ $type }}"
                                       aria-controls="{{ Str::slug($type) }}" 
                                       aria-selected="false"
                                       data-bs-dismiss="offcanvas">
                                        <span><i class="bi bi-folder me-2"></i>{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                                        <span class="gallery-count-{{ Str::slug($type) }}">
                                            {{ $galleryCounts[$type] ?? 0 }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <!-- Gallery Content -->
                <div class="col-lg-9 col-md-8">
                    <div class="tab-content" id="galleryTabContent">
                        <div id="gallery-loader">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading galleries...</p>
                        </div>
                        
                        @foreach ($galleryTypes as $type)
                            <div class="tab-pane fade" 
                                 id="{{ Str::slug($type) }}" 
                                 role="tabpanel" 
                                 aria-labelledby="tab-{{ Str::slug($type) }}"
                                 data-loaded="false">
                                <!-- Content will be loaded via AJAX -->
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    @push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewToggles = document.querySelectorAll('.view-toggle');
            const storageKey = 'galleryViewPreference';
            const savedView = localStorage.getItem(storageKey) || 'grid';
            const galleryTabs = document.querySelectorAll('#galleryTabs .nav-link, #mobileGalleryTabs .nav-link');
            const galleryLoader = document.getElementById('gallery-loader');
            const offcanvasInstance = new bootstrap.Offcanvas(document.getElementById('categoriesOffcanvas'));
            
            function handleHashNavigation() {
                const hash = window.location.hash;
                if (hash && hash.length > 1) {
                    const tabId = hash.substring(1);
                    const tab = document.querySelector(`[href="#${tabId}"]`);
                    
                    if (tab) {
                        tab.click();
                    } else {
                        loadDefaultTab();
                    }
                } else {
                    loadDefaultTab();
                }
            }
            
            function loadDefaultTab() {
                const firstTab = document.querySelector('#galleryTabs .nav-link');
                if (firstTab) {
                    firstTab.click();
                }
            }
            
            const mobileGalleryLinks = document.querySelectorAll('#mobileGalleryTabs .nav-link');
            mobileGalleryLinks.forEach(link => {
                link.addEventListener('click', function() {
                    offcanvasInstance.hide();
                });
            });
            
            function setupViewToggle() {
                document.querySelectorAll('.view-toggle').forEach(toggle => {
                    toggle.addEventListener('click', function() {
                        const view = this.getAttribute('data-view');
                        const tabPane = this.closest('.tab-pane');
                        
                        localStorage.setItem(storageKey, view);
                        
                        applyViewMode(tabPane, view);
                        
                        tabPane.querySelectorAll('.view-toggle').forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');
                    });
                });
            }
            
            function applyViewMode(tabPane, view) {
                const galleryContainer = tabPane.querySelector('.gallery-container');
                if (!galleryContainer) return;
                
                if (view === 'list') {
                    galleryContainer.classList.add('list-view');
                    tabPane.querySelectorAll('.gallery-item').forEach(item => {
                        item.classList.remove('col-lg-4', 'col-md-6');
                        item.classList.add('col-12', 'mb-3');
                    });
                } else {
                    galleryContainer.classList.remove('list-view');
                    tabPane.querySelectorAll('.gallery-item').forEach(item => {
                        item.classList.add('col-lg-4', 'col-md-6');
                        item.classList.remove('col-12', 'mb-3');
                    });
                }
            }
            
            function loadGalleryContent(tabElement) {
                const type = tabElement.getAttribute('data-type');
                const tabId = tabElement.getAttribute('href').substring(1);
                const tabPane = document.getElementById(tabId);
                
                history.pushState(null, null, `#${tabId}`);
                
                document.querySelectorAll(`[href="#${tabId}"]`).forEach(tab => {
                    tab.classList.add('active');
                    tab.setAttribute('aria-selected', 'true');
                });
                
                document.querySelectorAll('#galleryTabs .nav-link, #mobileGalleryTabs .nav-link').forEach(tab => {
                    if (tab.getAttribute('href') !== `#${tabId}`) {
                        tab.classList.remove('active');
                        tab.setAttribute('aria-selected', 'false');
                    }
                });
                
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.remove('show', 'active');
                });
                tabPane.classList.add('show', 'active');
                
                if (tabPane.getAttribute('data-loaded') === 'false') {
                    galleryLoader.style.display = 'block';
                    tabPane.style.opacity = '0.5';
                    
                    const url = "{{ route('gallery.type', ':type') }}".replace(':type', encodeURIComponent(type));
                    fetch(url, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            tabPane.innerHTML = data.html;
                            
                            const countBadges = document.querySelectorAll('.gallery-count-' + tabId);
                            countBadges.forEach(countBadge => {
                                if (countBadge) {
                                    countBadge.innerHTML = data.galleries.length;
                                }
                            });
                            
                            tabPane.setAttribute('data-loaded', 'true');
                            
                            setupViewToggle();
                            
                            applyViewMode(tabPane, savedView);
                            
                            const activeToggle = tabPane.querySelector(`.view-toggle[data-view="${savedView}"]`);
                            if (activeToggle) {
                                tabPane.querySelectorAll('.view-toggle').forEach(btn => btn.classList.remove('active'));
                                activeToggle.classList.add('active');
                            }
                        } else {
                            tabPane.innerHTML = '<div class="alert alert-danger">Failed to load galleries.</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching galleries:', error);
                        tabPane.innerHTML = '<div class="alert alert-danger">An error occurred while loading galleries.</div>';
                    })
                    .finally(() => {
                        galleryLoader.style.display = 'none';
                        tabPane.style.opacity = '1';
                    });
                }
            }
            
            galleryTabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    loadGalleryContent(this);
                });
            });
            
            handleHashNavigation();
            
            window.addEventListener('hashchange', handleHashNavigation);
        });
    </script>
    @endpush
</x-main-layout>