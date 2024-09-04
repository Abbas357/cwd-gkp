<x-app-layout>
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Roles</li>
    </x-slot>

    @push('style')
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    @endpush

    <div class="wrapper">
        <div class="page">
            <div class="page-inner">
                <div class="page-section">

                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-primary" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#create-roles" role="tab" aria-selected="true">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class="bi bi-plus-circle me-2 fs-6"></i></div>
                                            <div class="tab-title">Create Roles</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#assign-roles" role="tab" aria-selected="false">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class="bi bi-box-arrow-in-right me-2 fs-6"></i></div>
                                            <div class="tab-title">Assign Roles</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content py-3">

                                {{-- Tab 1 Start --}}
                                <div class="tab-pane fade show active" id="create-roles" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h3 class="card-title"> Add Roles </h3>
                                                    <form class="needs-validation" action="{{ route('roles.store') }}" method="post" novalidate>
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
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($roles as $role)
                                                            <tr>
                                                                <td>{{ $role->id }}</td>
                                                                <td>{{ $role->name }}</td>
                                                                <td>
                                                                    <form id="delete-role-form-{{ $role->id }}" method="post" action="{{ route('roles.destroy', ['role' => $role->id]) }}" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button" class="bg-light border-0 delete-role-btn" style="cursor: pointer;" data-role-id="{{ $role->id }}">
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
                                            {{ $roles->links() }}
                                        </div>
                                    </div>

                                </div>
                                {{-- Tab 1 End --}}

                                {{-- Tab 2 Start --}}
                                <div class="tab-pane fade" id="assign-roles" role="tabpanel">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h3 class="card-title"> Add roles to user </h3>
                                                    <form id="assignRoleForm" class="needs-validation" method="post" novalidate>
                                                        @csrf
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <label for="users">Users</label>
                                                                <select class="form-select form-select-md" data-placeholder="Choose" id="users" name="user">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <label for="roles">Roles</label>
                                                                <select class="form-select form-select-md" data-placeholder="Choose" id="roles" multiple name="roles[]">
                                                                    @foreach ($roles as $role)
                                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-actions">
                                                            <button class="btn btn-primary" type="submit">Assign Role</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h3 class="card-title mb-3 p-2"> List of roles </h3>
                                                    <table class="table p-5 table-stripped table-bordered">
                                                        <thead class="">
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Name</th>
                                                                <th>Roles</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($users as $user)
                                                            <tr>
                                                                <td>{{ $user->id }}</td>
                                                                <td>{{ $user->name }}</td>
                                                                <td>
                                                                    <ol>
                                                                        @foreach($user->roles as $role)
                                                                        <li> {{ $role->name }} <form id="delete-role-form-{{ $user->id }}-{{ $role->id }}" method="post" action="{{ route('users.role.revoke', ['user' => $user->id, 'role' => $role->id]) }}" style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="bg-light border-0" style="cursor: pointer;">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                                                                                    <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                                                                </svg>
                                                                            </button>
                                                                        </form></li>
                                                                        @endforeach
                                                                    </ol>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <form id="delete-all-roles-form-{{ $user->id }}" method="post" action="{{ route('users.roles.clear', ['user' => $user->id]) }}" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Clear All Roles</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            {{ $users->links() }}
                                        </div>
                                    </div>

                                </div>
                                {{-- Tab 2 End --}}
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var hash = window.location.hash;
            if (hash) {
                var $tabLink = $('a.nav-link[href="' + hash + '"]');

                if ($tabLink.length) {
                    var tab = new bootstrap.Tab($tabLink[0]);
                    tab.show();
                }
            }
            $('.nav-link').on('click', function() {
                window.location.hash = $(this).attr('href');
            });

            $('.delete-role-btn').on('click', async function() {
                const result = await confirmAction('Are you sure to delete the Role?');
                if (result && result.isConfirmed) {
                    var roleId = $(this).data('role-id');
                    $('#delete-role-form-' + roleId).submit();
                }
            });

            $('#users').select2(
                {
                    theme: "bootstrap-5",
                    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                    placeholder: $( this ).data( 'placeholder' ),
                    dropdownParent: $('#users').parent(),
                    ajax: {
                        url: '{{ route("users.api") }}',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term,
                                page: params.page || 1
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;

                            return {
                                results: data.items,
                                pagination: {
                                    more: data.pagination.more
                                }
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 0,
                    templateResult: formatUser,
                    templateSelection: formatUserSelection
                }
            );

            function formatUser(user) {
                if (user.loading) {
                    return user.text;
                }

                var $container = $(
                    "<div class='select2-result-user clearfix'>" +
                        "<div class='select2-result-user__name'></div>" +
                    "</div>"
                );

                $container.find(".select2-result-user__name").text(user.name);

                return $container;
            }

            function formatUserSelection(user) {
                return user.name || user.text;
            }

            $('#roles').select2(
                {
                    theme: "bootstrap-5",
                    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                    placeholder: $( this ).data( 'placeholder' ),
                    closeOnSelect: false,
                    dropdownParent: $('#roles').parent(),
                }
            );

            var routeUrl = '{{ route("users.roles", ["user" => "userId"]) }}';
            
            $('#users').on('change', function() {
                var userId = $(this).val();
                var form = $('#assignRoleForm');
                form.attr('action', routeUrl.replace('userId', userId));
            });


        });

    </script>
    @endpush
</x-app-layout>
