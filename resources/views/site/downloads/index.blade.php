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
                <!-- Left-aligned Tabs -->
                <ul class="nav nav-pills nav-sm flex-column" id="categoryTabs" role="tablist">
                    @foreach ($downloadsByCategory as $category => $downloads)
                    <li class="nav-item bg-light mb-1" role="presentation">
                        <a class="nav-link p-2 @if($loop->first) active @endif"
                            id="tab-{{ Str::slug($category) }}"
                            data-bs-toggle="tab"
                            href="#{{ Str::slug($category) }}"
                            role="tab"
                            aria-controls="{{ Str::slug($category) }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            <i class="bi-arrow-right-circle"></i> &nbsp; {{ $category }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-9">
                <!-- Right-aligned Tab Content -->
                <div class="tab-content" id="categoryTabContent">
                    @foreach ($downloadsByCategory as $category => $downloads)
                    <div class="tab-pane fade @if($loop->first) show active @endif"
                        id="{{ Str::slug($category) }}"
                        role="tabpanel"
                        aria-labelledby="tab-{{ Str::slug($category) }}">

                        <h4>{{ $category }} Downloads</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>File Name</th>
                                    <th>File Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($downloads as $download)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $download->file_name }}</td>
                                    <td>{{ $download->file_type ?? 'N/A' }}</td>
                                    <td>
                                        @if ($media = $download->getFirstMediaUrl('downloads'))
                                        <a href="{{ $media }}" class="btn btn-primary btn-sm btn-animate" style="white-space: nowrap">
                                            <i class="bi-cloud-arrow-down"></i> Download
                                        </a>
                                        @else
                                        <span class="text-muted">No file available</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No downloads available in this category.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-main-layout>