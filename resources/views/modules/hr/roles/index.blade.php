<x-hr-layout>
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Roles</li>
    </x-slot>

    <div class="wrapper">
        <div class="page">
            <div class="page-inner">
                <div class="page-section">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="card-title"> Add Roles </h3>
                                            <form class="needs-validation" action="{{ route('admin.apps.hr.roles.store') }}" method="post" novalidate>
                                                @csrf
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name" placeholder="Name" required>
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    <button class="btn btn-primary" type="submit">Add Role</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="card-title mb-3 p-2"> List of Roles </h3>
                                            <table class="table p-5 table-stripped table-bordered">
                                                <thead class="">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Permissions</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($roles as $role)
                                                    <tr>
                                                        <td>{{ $role->id }}</td>
                                                        <td>{{ $role->name }}</td>
                                                        <td>
                                                            <ul>
                                                                @foreach($role->permissions as $permission)
                                                                    <li> {{ $permission->name }} </li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            <i class="permissions-btn cursor-pointer bi-pencil-square fs-5" title="All Permissions" data-bs-toggle="tooltip" data-id="{{ $role->id }}"></i>
                                                            <form id="delete-role-form-{{ $role->id }}" method="post" action="{{ route('admin.apps.hr.roles.destroy', ['role' => $role->id]) }}" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="bg-light border-0 delete-role-btn" style="cursor: pointer;" data-role-id="{{ $role->id }}">
                                                                    <i class="cursor-pointer bi-trash fs-5" title="Delete Role" data-bs-toggle="tooltip" data-id="{{ $role->id }}"></i>
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
                                    {{ $roles->links() }}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="assignPermissions" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="permissions-update" novalidate>
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="loading-spinner text-center mt-2" style="display: none">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="card mb-0">
                            <div class="card-body" style="height:500px">
                                <input type="text" id="search-permissions" class="form-control mb-3" placeholder="Search Permissions">
                                <div class="user-details">
                                    <div id="permissions" class="d-flex flex-wrap justify-content-evenly align-items-center gap-2">
                                        <!-- Permissions will be populated dynamically -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="update-permissions" class="btn btn-primary px-3">Update Permissions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    @push('script')
    <script>
        $(document).ready(function() {

            const $searchInput = $('#search-permissions');

            if ($searchInput.length) {
                $searchInput.on('keyup', function () {
                    const searchQuery = $(this).val().toLowerCase();
                    const $permissionItems = $('#permissions .form-check');

                    if ($permissionItems.length === 0) {
                        console.warn('No permission items found.');
                        return;
                    }

                    $permissionItems.each(function () {
                        const $label = $(this).find('label');
                        const text = $label.text().toLowerCase();
                        $(this).toggle(text.includes(searchQuery));
                    });
                });
            } else {
                console.error('Search input field not found.');
            }

            $('.delete-role-btn').on('click', async function() {
                const result = await confirmAction('Are you sure to delete the Role?');
                if (result && result.isConfirmed) {
                    var roleId = $(this).data('role-id');
                    $('#delete-role-form-' + roleId).submit();
                }
            });

            async function openModalFromUrl() {
                const hash = window.location.hash;
                const urlParams = new URLSearchParams(window.location.search);
                const roleId = urlParams.get('id');
                const url = "{{ route('admin.apps.hr.roles.getPermissions', ':id') }}".replace(':id', roleId);
                const updateURL = "{{ route('admin.apps.hr.roles.updatePermissions', ':id') }}".replace(':id', roleId);
                $('#permissions-update').attr('action', updateURL);

                if (hash === '#permissions' && roleId) {
                    $('#assignPermissions').modal('show');
                    $('#assignPermissions .loading-spinner').show();
                    $('#assignPermissions .user-details').hide();

                    const data = await fetchRequest(url);
                    let role = data.role;
                    let permissions = data.permissions;
                    if (role) {
                        $('#assignPermissions .modal-title').html('Permission for <strong>(' + role + ')</strong>')
                        const permissionsContainer = $('#permissions');
                        function isPermissionAssigned(permission) {
                            return permissions.some(userPermission => userPermission.name === permission.name);
                        }
                        $.each(data.allPermissions, function(index, permission) {
                            const isChecked = isPermissionAssigned(permission) ? 'checked' : '';
                            const $permissions = $(`
                                <div class="form-check px-2">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="${permission.name}" id="permission${permission.id}" ${isChecked}>
                                    <label class="form-check-label" for="permission${permission.id}">${permission.name}</label>
                                </div>
                            `);
                            permissionsContainer.append($permissions);
                        });
                    } else {
                        $('#assignPermissions .modal-title').text('Error');
                        $('#assignPermissions .user-details').html('<p>Failed to load permissions.</p>');
                    }
                    $('#assignPermissions .loading-spinner').hide();
                    $('#assignPermissions .user-details').show();
                }
            }

            $(document).on('click', '.permissions-btn', async function() {
                const roleId = $(this).data('id');
                const newUrl = `${window.location.pathname}?id=${roleId}#permissions`;
                history.pushState(null, null, newUrl);
                openModalFromUrl();
            });

            $(window).on('popstate', function() {
                openModalFromUrl();
            });

            openModalFromUrl();

            $('#assignPermissions').on('hidden.bs.modal', function() {
                $('#permissions').empty();
                $('#permissions-update').trigger("reset");
                history.pushState(null, null, window.location.pathname);
            });

            $(document).on('submit', '#permissions-update', async function(e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);
                const url = $(this).attr('action');
                setButtonLoading('#update-permissions');
                
                const result = await fetchRequest(url, 'POST', formData);
                if (result) {
                    form.reset();
                    setButtonLoading('#update-permissions', false);
                    $('#assignPermissions').modal('hide');
                    $('#permissions').empty();
                }
            });

        });

    </script>
    @endpush
</x-hr-layout>
