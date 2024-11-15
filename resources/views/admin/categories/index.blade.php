<x-app-layout class="Add Categories">
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Categories</li>
    </x-slot>

    @push('style')
    @endpush

    <div class="wrapper">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title"> Add Category </h3>
                        <form class="needs-validation" action="{{ route('admin.categories.store') }}" method="post" novalidate>
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name" placeholder="Name" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value=""> Choose... </option>
                                        @foreach(categoryType() as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button class="btn btn-primary" type="submit">Add Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title mb-3 p-2"> List of Categories </h3>
                        <div class="row mb-3">
                            <div class="col">
                                <form action="{{ route('admin.categories.index') }}" method="GET">
                                    <label for="type" class="form-label">Filter</label>
                                    <select class="form-select" id="type" name="type" required onchange="this.form.submit()">
                                        <option value=""> Choose... </option>
                                        @foreach(categoryType() as $cat)
                                        <option value="{{ $cat }}" {{ request('type') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                        <table class="table p-5 table-stripped table-bordered">
                            <thead class="">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->type }}</td>
                                    <td>
                                        <form id="delete-category-form-{{ $category->id }}" method="post" action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="bg-light border-0 delete-category-btn" style="cursor: pointer;" data-category-id="{{ $category->id }}">
                                                <i class="cursor-pointer bi-trash fs-5" title="Delete Permission" data-bs-toggle="tooltip" data-id="{{ $category->id }}"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Pagination links -->
                {{ $categories->links() }}
            </div>
        </div>
    </div>

    @push('script')
    <script>
        $(document).ready(function() {
            $('.delete-category-btn').on('click', async function() {
                const result = await confirmAction('Are you sure to delete the Permission?');
                if (result && result.isConfirmed) {
                    var categoryId = $(this).data('category-id');
                    $('#delete-category-form-' + categoryId).submit();
                }
            });

        });

    </script>
    @endpush
</x-app-layout>
