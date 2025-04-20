<x-settings-layout title="Categories">
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
        <li class="breadcrumb-item active" aria-current="page">Categories</li>
    </x-slot>

    <div class="wrapper">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Categories</h5>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Category
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Module</th>
                                <th>Items</th>
                                <th>Description</th>
                                @can('manageMainCategory', App\Models\Setting::class)
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                @php
                                    $items = json_decode($category->value, true);
                                    $itemCount = count($items);
                                @endphp
                                <tr>
                                    <td>{{ $category->key }}</td>
                                    <td>{{ $category->module }}</td>
                                    <td>{{ $itemCount }} items</td>
                                    <td>{{ $category->description }}</td>
                                    @can('manageMainCategory', App\Models\Setting::class)
                                    <td>
                                        <div class="btn-group" role="group">

                                            <a href="{{ route('admin.categories.show', [$category->key, $category->module]) }}" 
                                                class="btn btn-sm btn-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', [$category->key, $category->module]) }}" 
                                                class="btn btn-sm btn-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.categories.destroy', [$category->key, $category->module]) }}" 
                                                  onsubmit="return confirm('Are you sure you want to delete this category?');" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-settings-layout>