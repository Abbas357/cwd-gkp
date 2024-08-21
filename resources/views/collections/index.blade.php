<x-app-layout>
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Collections</li>
    </x-slot>

    @push('style')
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
    @endpush

    <div class="wrapper">
        <div class="page">
            <div class="page-inner">
                <div class="page-section">
                    <div class="d-xl-none">
                        <button class="btn btn-danger btn-floated" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="fa fa-th-list"></i></button>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title"> Fill all the fields </h3>
                                    <form action="{{ route('collections.store') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="type" class="form-label">Type <abbr title="Required">*</abbr></label>
                                                <select class="form-select" id="type" name="type" required>
                                                    <option value=""> Choose... </option>
                                                    @foreach (cat_types() as $cat)
                                                    <option value="{{ $cat }}"> {{ $cat }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label for="name" class="form-label">Name <abbr title="Required">*</abbr></label>
                                                <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name" placeholder="Name" required>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button class="btn btn-primary" type="submit">Add Collection</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table p-5 table-stripped table-bordered">
                                        <thead class="">
                                            <tr>
                                                <th>ID</th>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $category)
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->type }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    <form action="{{ route('collections.destroy', ['collection' => $category->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" style="display:inline;">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="badge bg-secondary border-0" style="cursor: pointer;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                                                                <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                                            </svg>
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
            </div>
        </div>
    </div>

    @push('script')
    @endpush
</x-app-layout>
