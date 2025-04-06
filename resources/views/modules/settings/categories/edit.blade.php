<x-settings-layout title="Edit Category">
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit {{ $category->key }}</li>
    </x-slot>

    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Category: {{ $category->key }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.update', [$category->key, $category->module]) }}" class="needs-validation" novalidate>
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label for="key" class="form-label">Category Key</label>
                        <input type="text" class="form-control" id="key" value="{{ $category->key }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="module" class="form-label">Module</label>
                        <input type="text" class="form-control" id="module" value="{{ $category->module }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                            id="description" name="description" rows="2">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <h5 class="mt-4 mb-3">Category Items</h5>
                    
                    <div class="mb-3">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="itemsTable">
                                <thead>
                                    <tr>
                                        <th width="90%">Item</th>
                                        <th width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $index => $item)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="items[]" 
                                                       value="{{ $item }}" required>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-danger remove-item">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr id="newItemRow">
                                        <td>
                                            <input type="text" class="form-control" id="newItem" placeholder="New Item">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-success" id="addItemBtn">
                                                <i class="bi bi-plus-circle"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
    <script>
        $(document).ready(function() {
            // Add new item
            $('#addItemBtn').on('click', function() {
                const newItem = $('#newItem').val().trim();
                
                if (newItem === '') {
                    alert('Item cannot be empty!');
                    return;
                }
                
                // Add to table
                const newRow = `
                    <tr>
                        <td>
                            <input type="text" class="form-control" name="items[]" 
                                   value="${newItem}" required>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger remove-item">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                
                $(newRow).insertBefore('#newItemRow');
                
                // Clear input
                $('#newItem').val('');
            });
            
            // Remove item
            $(document).on('click', '.remove-item', function() {
                if (confirm('Are you sure you want to remove this item?')) {
                    $(this).closest('tr').remove();
                }
            });
        });
    </script>
    @endpush
</x-settings-layout>