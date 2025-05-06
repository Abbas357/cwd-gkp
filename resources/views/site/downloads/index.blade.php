<x-main-layout title="All Downloads">
    @push('style')
    <style>
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
        
        .download-sidebar {
            position: sticky;
            top: 2rem;
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
                top: 20rem;
                right: 0px;
                z-index: 999;
                border-radius: 50%;
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
                border-radius: 50%;
                animation: ripple .5s cubic-bezier(0.895, 0.03, 0.685, 0.22) infinite;
                pointer-events: none;
            }

            @keyframes ripple {
                0% {
                    box-shadow: 0 0 0 0 rgba(0,0,0,0.3);
                }
                100% {
                    box-shadow: 0 0 0 20px rgba(0,0,0,0);
                }
            }
        }

        .file-icon {
            font-size: 1.2rem;
            vertical-align: middle;
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
            <!-- Mobile Category Button (visible on small screens) -->
            <div class="d-md-none d-block">
                <button class="btn btn-light border border-secondary category-toggle-btn shadow" type="button" data-bs-toggle="offcanvas" data-bs-target="#categoriesOffcanvas">
                    <i class="bi bi-layout-three-columns"></i>
                </button>
            </div>
            
            <!-- Sidebar with Categories (Hidden on mobile) -->
            <div class="col-md-3 d-none d-md-block" style="height: 550px; overflow-y: auto;">
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
                                    <a class="nav-link @if($loop->first) active @endif" 
                                       id="tab-{{ Str::slug($category) }}" 
                                       data-category="{{ $category }}" 
                                       data-bs-toggle="tab" 
                                       href="#{{ Str::slug($category) }}" 
                                       role="tab" 
                                       aria-controls="{{ Str::slug($category) }}" 
                                       aria-selected="{{ $loop->first ? 'true' : 'false' }}">
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
            <div class="offcanvas offcanvas-start offcanvas-downloads" tabindex="-1" id="categoriesOffcanvas" aria-labelledby="categoriesOffcanvasLabel">
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
                            <a class="nav-link @if($loop->first) active @endif" 
                               id="mobile-tab-{{ Str::slug($category) }}"
                               data-category="{{ $category }}" 
                               data-bs-toggle="tab" 
                               href="#{{ Str::slug($category) }}" 
                               role="tab" 
                               aria-controls="{{ Str::slug($category) }}" 
                               aria-selected="{{ $loop->first ? 'true' : 'false' }}"
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
            <div class="col-md-9 border border-light shadow-sm">
                <div class="tab-content" id="categoryTabContent">
                    @foreach ($categories as $category)
                    <div id="{{ Str::slug($category) }}" class="tab-pane fade @if ($loop->first) show active @endif">
                        @if ($loop->first)
                        <!-- First category content is loaded directly -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light border-0 py-3">
                                <h5 class="m-0">
                                    <i class="bi bi-folder2-open me-2"></i>{{ $firstCategory }} Downloads
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover mb-0">
                                        <thead class="table-secondary text-uppercase">
                                            <tr>
                                                <th>#</th>
                                                <th>File Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($firstCategoryDownloads as $download)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @php
                                                        $icons = [
                                                            'pdf' => 'bi-file-earmark-pdf text-danger',
                                                            'doc' => 'bi-file-earmark-word text-primary',
                                                            'docx' => 'bi-file-earmark-word text-primary',
                                                            'docs' => 'bi-file-earmark-word text-primary',
                                                            'image' => 'bi-file-earmark-image text-info',
                                                            'xlsx' => 'bi-file-earmark-excel text-success',
                                                            'xls' => 'bi-file-earmark-excel text-success',
                                                            'ppt' => 'bi-file-earmark-slides text-warning',
                                                            'pptx' => 'bi-file-earmark-slides text-warning',
                                                            'zip' => 'bi-file-earmark-zip text-secondary',
                                                            'txt' => 'bi-file-earmark-text text-dark',
                                                        ];
                                                        $fileType = strtolower($download->file_type ?? 'default');
                                                        $iconClass = $icons[$fileType] ?? 'bi-file-earmark';
                                                    @endphp
                                                    <span class="rounded bg-light p-1 me-3 border border-success shadow-sm">
                                                        <i class="bi {{ $iconClass }} file-icon"></i>
                                                        <span style="font-size:12px; color: #777"> .{{ $download->file_type ?? 'N/A' }} </span>
                                                    </span>
                                                    {{ $download->file_name }}
                                                </td>
                                                <td>
                                                    @if ($media = $download->getFirstMediaUrl('downloads'))
                                                    <a href="{{ $media }}" class="cw-btn bg-light text-dark" 
                                                       data-id="{{ $download->id }}" target="_blank">
                                                        <i class="bi-download me-1"></i> Download
                                                    </a>
                                                    @else
                                                    <span class="text-muted">No file available</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No downloads available in this category.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @else
                        <!-- Other categories loaded via AJAX -->
                        <div class="d-flex justify-content-center p-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
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

            mobileTabLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (offcanvasInstance) {
                        offcanvasInstance.hide();
                    }
                });
            });
            
            const categoryTabs = document.querySelectorAll('[data-category]');
            
            // Function to load tab content via AJAX
            const loadTabContent = (tab) => {
                const category = tab.getAttribute('data-category');
                const tabPaneId = tab.getAttribute('href').substring(1); 
                const tabPane = document.getElementById(tabPaneId);
                
                // Skip if content is already loaded (not just a spinner)
                if (tabPane && tabPane.querySelector('.card') && !tabPane.querySelector('.spinner-border')) {
                    return;
                }
                
                // Show loading spinner
                tabPane.innerHTML = `<div class="d-flex justify-content-center p-5">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>`;
                
                // Fetch the data via AJAX
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
                    // Create a wrapper for the response content
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = data.downloads;
                    
                    // Create card structure
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
                    tabPane.innerHTML = '<div class="p-4 text-center text-danger">Failed to load content. Please try again.</div>';
                });
            };

            // Set up click event for all tabs
            categoryTabs.forEach(tab => {
                tab.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    // Activate this tab
                    document.querySelectorAll('.nav-link').forEach(t => {
                        t.classList.remove('active');
                        t.setAttribute('aria-selected', 'false');
                    });
                    
                    // Find and activate both mobile and desktop tabs
                    const tabId = tab.getAttribute('href').substring(1);
                    document.querySelectorAll(`[href="#${tabId}"]`).forEach(t => {
                        t.classList.add('active');
                        t.setAttribute('aria-selected', 'true');
                    });
                    
                    // Show this tab's content
                    document.querySelectorAll('.tab-pane').forEach(p => {
                        p.classList.remove('show', 'active');
                    });
                    const tabPane = document.getElementById(tabId);
                    tabPane.classList.add('show', 'active');
                    
                    // Load content if needed
                    loadTabContent(tab);
                    
                    // Update URL hash without scrolling
                    history.replaceState(null, null, '#' + tabId);
                });
            });
            
            // Check for hash in URL on page load
            if (window.location.hash) {
                const hash = window.location.hash.substring(1);
                const matchingTab = document.querySelector(`.nav-link[href="#${hash}"]`);
                
                if (matchingTab) {
                    // Simulate a click on the matching tab
                    matchingTab.click();
                }
            }

            // Category Search Implemented below
            const categorySearch = document.getElementById('categorySearch');
            if (categorySearch) {
                categorySearch.addEventListener('input', function() {
                    filterTabs('categoryTabs', this.value.toLowerCase());
                });
            }
            
            // Setup search functionality for mobile tabs
            const mobileCategorySearch = document.getElementById('mobileCategorySearch');
            if (mobileCategorySearch) {
                mobileCategorySearch.addEventListener('input', function() {
                    filterTabs('mobileCategoryTabs', this.value.toLowerCase());
                });
            }
            
            // Function to filter tabs based on search input
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
                
                // Show a "no results" message if no tabs match
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