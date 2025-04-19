<x-settings-layout title="Create Category">
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create</li>
    </x-slot>

    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Create New Category</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.store') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="key" class="form-label">Category Key</label>
                        <input type="text" class="form-control @error('key') is-invalid @enderror" 
                            id="key" name="key" value="{{ old('key') }}" required>
                        <div class="form-text">A unique identifier for this category (e.g., vehicle_types)</div>
                        @error('key')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="module" class="form-label">Module</label>
                        <select class="form-select" id="module" name="module">
                            <option value="main">Main Site</option>
                            <option value="hr">HR-MIS</option>
                            <option value="vehicle">Vehicle Mgt.</option>
                            <option value="dmis">Damage Management & Information System</option>
                        </select>
                        <div class="form-text">Where this settings belongs to</div>
                        @error('module')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                            id="description" name="description" rows="2">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <h5 class="mt-4 mb-3">Initial Items</h5>
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
                        <button type="submit" class="btn btn-primary">Create Category</button>
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