<x-main-layout title="All Downloads">
    <x-slot name="breadcrumbTitle">
        Downloads
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Downloads</li>
    </x-slot>
    <div class="container my-3">
        <div class="row">
            <div class="col-md-3">
                <ul class="nav nav-pills nav-sm flex-column" id="categoryTabs" role="tablist">
                    @foreach ($categories as $category)
                    <li class="nav-item bg-light mb-1" role="presentation">
                        <a class="nav-link p-2 @if($loop->first) active @endif" id="tab-{{ Str::slug($category) }}" data-category="{{ $category }}" data-bs-toggle="tab" href="#{{ Str::slug($category) }}" role="tab" aria-controls="{{ Str::slug($category) }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            <i class="bi-arrow-right-circle"></i> &nbsp; {{ $category }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-9">
                <div class="tab-content" id="categoryTabContent">
                    @foreach ($categories as $category)
                    <div id="{{ Str::slug($category) }}" class="tab-pane fade @if ($loop->first) show active @endif">
                        @if ($loop->first)
                        @include('site.downloads.partials.downloads_table', [
                        'downloads' => $firstCategoryDownloads,
                        'category' => $firstCategory
                        ])
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-main-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const categoryTabs = document.querySelectorAll('.nav-link');

        categoryTabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();

                const category = tab.getAttribute('data-category');
                const tabPaneId = tab.getAttribute('href').substring(1); 
                const tabPane = document.getElementById(tabPaneId);

                if (tabPane && tabPane.children.length > 0) {
                    return;
                }

                tabPane.innerHTML = '<p class="text-center">Loading...</p>';
                tabPane.classList.add('show', 'active');
-
                fetch(`/downloads/fetch-category`, {
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                        , body: JSON.stringify({
                            category
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        tabPane.innerHTML = data.downloads;
                    })
                    .catch(error => {
                        console.error('Error fetching category:', error);
                        tabPane.innerHTML = '<p class="text-center text-danger">Failed to load content. Please try again.</p>';
                    });
            });
        });
    });

</script>
