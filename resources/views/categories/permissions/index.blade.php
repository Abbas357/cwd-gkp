<x-app-layout>
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Permissions</li>
    </x-slot>

    @push('style')
    @endpush

    <div class="wrapper">
        <div class="page">
            <div class="page-inner">
                <div class="page-section">
                    <div class="d-xl-none">
                        <button class="btn btn-danger btn-floated" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"><i class="fa fa-th-list"></i></button>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title"> Add Permissions </h3>
                                    <form action="{{ route('permissions.store') }}" method="post">
                                        @csrf
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name" placeholder="Name" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="guard_name" class="form-label">Guard Name</label>
                                                <select class="form-select" id="guard_name" name="guard_name">
                                                    <option value=""> Choose... </option>
                                                    <option value="web">Web</option>
                                                    <option value="api">API</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button class="btn btn-primary" type="submit">Add Permission</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title mb-3 p-2"> List of Permissions </h3>
                                    <table class="table p-5 table-stripped table-bordered">
                                        <thead class="">
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Guard Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $permission)
                                            <tr>
                                                <td>{{ $permission->id }}</td>
                                                <td>{{ $permission->name }}</td>
                                                <td>{{ $permission->guard_name }}</td>
                                                <td>
                                                    <form id="delete-permission-form-{{ $permission->id }}" method="post" action="{{ route('permissions.destroy', ['permission' => $permission->id]) }}" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="bg-light border-0 delete-permission-btn" style="cursor: pointer;" data-permission-id="{{ $permission->id }}">
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
                            {{ $permissions->links() }}
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
            $('.delete-permission-btn').on('click', async function() {
                const result = await confirmAction('Are you sure to delete the Permission?');
                if (result && result.isConfirmed) {
                    var permissionId = $(this).data('permission-id');
                    $('#delete-permission-form-' + permissionId).submit();
                }
            });

        });

    </script>
    @endpush
</x-app-layout>
