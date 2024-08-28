<x-app-layout>
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Contractor Category</li>
    </x-slot>

    @push('style')
    @endpush

    <div class="wrapper">
        <div class="page">
            <div class="page-inner">
                <div class="page-section">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title"> Add Contractor Categories </h3>
                                    <form action="{{ route('contractor_categories.store') }}" method="post">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name" placeholder="Name" required>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button class="btn btn-primary" type="submit">Add Provincial Entity</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title mb-3 p-2"> List of Contractor Categories </h3>
                                    <table class="table p-5 table-stripped table-bordered">
                                        <thead class="">
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contractor_categories as $contractor_category)
                                            <tr>
                                                <td>{{ $contractor_category->id }}</td>
                                                <td>{{ $contractor_category->name }}</td>
                                                <td>
                                                    <form id="delete-contractor_category-form-{{ $contractor_category->id }}" method="post" action="{{ route('contractor_categories.destroy', ['contractor_category' => $contractor_category->id]) }}" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="bg-light border-0 delete-contractor_category-btn" style="cursor: pointer;" data-contractor_category-id="{{ $contractor_category->id }}">
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
                            {{ $contractor_categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('plugins/sweetalert2@11.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.delete-contractor_category-btn').on('click', async function() {
                const result = await confirmAction('Are you sure to delete the Provincial Entity?');
                if (result && result.isConfirmed) {
                    var contractor_categoryId = $(this).data('contractor_category-id');
                    $('#delete-contractor_category-form-' + contractor_categoryId).submit();
                }
            });

        });

    </script>
    @endpush
</x-app-layout>
