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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title"> Add Permissions </h3>
                                    <form class="needs-validation" action="{{ route('admin.permissions.store') }}" method="post" novalidate>
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
                                                <th>Used by Roles</th>
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
                                                    <ul>
                                                        @foreach($permission->roles as $role)
                                                            <li> {{ $role->name }} </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    <form id="delete-permission-form-{{ $permission->id }}" method="post" action="{{ route('admin.permissions.destroy', ['permission' => $permission->id]) }}" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="bg-light border-0 delete-permission-btn" style="cursor: pointer;" data-permission-id="{{ $permission->id }}">
                                                            <i class="cursor-pointer bi-trash fs-5" title="Delete Permission" data-bs-toggle="tooltip" data-id="{{ $permission->id }}"></i>
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
