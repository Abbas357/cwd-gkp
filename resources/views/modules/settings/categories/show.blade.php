<x-settings-layout title="View Category">
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $category->key }}</li>
    </x-slot>

    <div class="wrapper">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Category: {{ $category->key }}</h5>
                <div>
                    <a href="{{ route('admin.categories.edit', [$category->key, $category->module]) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Details</h6>
                        <table class="table">
                            <tr>
                                <th width="30%">Key:</th>
                                <td>{{ $category->key }}</td>
                            </tr>
                            <tr>
                                <th>Module:</th>
                                <td>{{ $category->module }}</td>
                            </tr>
                            <tr>
                                <th>Description:</th>
                                <td>{{ $category->description ?: 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Total Items:</th>
                                <td>{{ count($items) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <h6>Category Items</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th width="90%">Item</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">No items in this category</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-settings-layout>