<x-hr-layout>
    @push('style')
    <style>
        .permission-category h6 {
            color: #6c757d;
            font-weight: 600;
        }

        .form-check-label {
            user-select: none;
        }

        .user-item.active {
            background-color: #f8f9fa;
            font-weight: 500;
        }

        .bulk-actions {
            transition: all 0.3s ease;
        }

        .form-switch .form-check-input {
            height: 1.25rem;
            width: 2.5rem;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .cw-btn-shake {
            animation: shake 0.5s;
        }

        .cw-field-shake {
            animation: shake 0.5s;
        }

        .cw-nav-link-shake {
            animation: shake 0.5s;
        }

        .cw-tab-alert {
            position: relative;
            color: #dc3545 !important;
            font-weight: bold;
        }

        .cw-tab-alert::after {
            content: "!";
            position: absolute;
            top: -5px;
            right: -5px;
            width: 18px;
            height: 18px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            font-weight: bold;
        }

        .role-card,
        .permission-card {
            transition: all 0.2s ease-in-out;
            border-radius: 0.5rem;
        }

        .role-card:hover,
        .permission-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-check-input.role-toggle,
        .form-check-input.permission-toggle {
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .user-item {
            transition: all 0.2s ease;
        }

        .user-item.active {
            border-left: 3px solid #0d6efd;
            background-color: rgba(13, 110, 253, 0.05) !important;
        }

        .user-item:hover:not(.active) {
            background-color: #f8f9fa;
        }

        .permission-category h6 {
            position: relative;
            padding-left: 10px;
        }

        .permission-category h6::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 16px;
            background-color: #0d6efd;
            border-radius: 2px;
        }

        /* Tab styles */
        .nav-tabs .nav-link {
            color: #6c757d;
            border: none;
            padding: 0.5rem 1rem;
            font-weight: 500;
            position: relative;
        }

        .nav-tabs .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #0d6efd;
            transition: width 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            color: #0d6efd;
            background-color: transparent;
            border: none;
        }

        .nav-tabs .nav-link.active::after {
            width: 100%;
        }

        /* Switch style */
        .form-switch .form-check-input {
            width: 2.5em;
            margin-left: -2.5em;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e");
            transition: background-position 0.15s ease-in-out;
        }

        .form-switch .form-check-input:checked {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
        }

        .form-switch .form-check-input:focus {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e");
        }

        /* Search input styles */
        .input-group-text {
            background-color: #f8f9fa;
        }

        .input-group .form-control {
            border-left: none;
        }

        .input-group .form-control:focus {
            border-color: #ced4da;
            box-shadow: none;
        }

        /* Pagination styles */
        .pagination {
            justify-content: center;
            margin-bottom: 0;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .pagination .page-link {
            color: #0d6efd;
        }

        /* Animate permission toggles */
        .form-switch .form-check-input {
            transition: all 0.2s ease;
        }

        .form-switch .form-check-input:checked {
            transform: scale(1.1);
        }

        .form-switch .form-check-input:not(:checked) {
            background-color: #e9ecef;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tab-pane.fade.show.active {
            animation: fadeIn 0.3s ease;
        }

        .user-badge {
            transition: all 0.2s ease;
        }

        .user-badge:hover {
            background-color: #e9ecef !important;
        }

        /* Improved modals */
        .modal-content {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .spinner-border {
            width: 1.5rem;
            height: 1.5rem;
            border-width: 0.2em;
        }

    </style>
    @endpush
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Role Management</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRoleModal">
                            <i class="bi bi-plus-circle me-1"></i> New Role
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <!-- Left Panel - Users List -->
            <div class="col-md-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="card-title mb-0">Users</h6>
                        <div class="mt-2">
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <select id="office-filter" class="form-select form-select-sm">
                                        <option value="">All Offices</option>
                                        @foreach($offices as $office)
                                        <option value="{{ $office->id }}">{{ $office->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <select id="designation-filter" class="form-select form-select-sm">
                                        <option value="">All Designations</option>
                                        @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button id="filter-btn" class="btn btn-sm btn-outline-primary w-100">Filter</button>
                                </div>
                            </div>
                            <div class="input-group mt-2">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                <input type="text" id="user-search" class="form-control border-0 bg-light" placeholder="Search users...">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="d-flex p-2 align-items-center">
                            <div class="form-check me-2">
                                <input class="form-check-input" type="checkbox" id="select-all-users">
                                <label class="form-check-label" for="select-all-users">
                                    Select All
                                </label>
                            </div>
                            <div class="bulk-actions ms-auto" style="display: none;">
                                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                                    Bulk Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#bulkAssignRolesModal">Assign Roles</a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#bulkAssignPermissionsModal">Assign Permissions</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="list-group list-group-flush" id="users-list" style="max-height: 600px; overflow-y: auto;">
                            @foreach($users as $user)
                            <div class="list-group-item list-group-item-action d-flex align-items-center user-item p-2" data-user-id="{{ $user->id }}">
                                <div class="form-check me-2">
                                    <input class="form-check-input user-checkbox" type="checkbox" value="{{ $user->id }}" id="user-{{ $user->id }}">
                                </div>
                                <div class="d-flex align-items-center flex-grow-1">
                                    <img src="{{ $user->getFirstMediaUrl('profile_pictures', 'thumb') ?: asset('admin/images/default-avatar.jpg') }}" class="rounded-circle me-2" width="32" height="32">
                                    <div>
                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                        <small class="text-muted">
                                            {{ $user->currentDesignation->name ?? 'No designation' }}
                                            <span class="text-secondary">&bull;</span>
                                            {{ $user->currentOffice->name ?? 'No office' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Roles & Permissions -->
            <div class="col-md-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <div id="user-info-placeholder">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('admin/images/default-avatar.jpg') }}" class="rounded-circle me-2" width="40" height="40">
                                <div>
                                    <h6 class="mb-0 text-muted">Select a user</h6>
                                    <small class="text-muted">Click on a user to view and manage their roles and permissions</small>
                                </div>
                            </div>
                        </div>

                        <div id="user-info" style="display: none;">
                            <div class="d-flex align-items-center">
                                <img id="user-avatar" src="" class="rounded-circle me-2" width="40" height="40">
                                <div>
                                    <h6 id="user-name" class="mb-0"></h6>
                                    <small id="user-details" class="text-muted"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="no-user-selected" class="text-center py-5">
                            <i class="bi bi-person-badge text-muted" style="font-size: 3rem;"></i>
                            <p class="mt-2 text-muted">Select a user to manage their roles and permissions</p>
                        </div>

                        <div id="roles-permissions-content" style="display: none;">
                            <ul class="nav nav-tabs" id="rolePermissionTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles-tab-pane" type="button" role="tab">
                                        Roles
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions-tab-pane" type="button" role="tab">
                                        Direct Permissions
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content mt-3">
                                <!-- Roles Tab -->
                                <div class="tab-pane fade show active" id="roles-tab-pane" role="tabpanel">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                        <input type="text" id="role-search" class="form-control border-0 bg-light" placeholder="Search roles...">
                                    </div>
                                    <div id="roles-list" class="row g-3">
                                        <!-- Roles will be populated dynamically -->
                                    </div>
                                </div>

                                <!-- Direct Permissions Tab -->
                                <div class="tab-pane fade" id="permissions-tab-pane" role="tabpanel">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                        <input type="text" id="permission-search" class="form-control border-0 bg-light" placeholder="Search permissions...">
                                    </div>
                                    <div id="permissions-container">
                                        <!-- Permission categories will be dynamically populated -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Role Modal -->
    <div class="modal fade" id="newRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="create-role-form" action="{{ route('admin.apps.hr.roles.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="role-name" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="role-name" name="name" required>
                            <div class="form-text">Role name should be descriptive (e.g., "Content Editor", "HR Manager")</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Permissions</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                <input type="text" id="new-role-permission-search" class="form-control border-0 bg-light" placeholder="Search permissions...">
                            </div>
                            <div class="card border-light">
                                <div class="card-body p-2" style="max-height: 300px; overflow-y: auto;">
                                    <div id="new-role-permissions-container">
                                        <!-- Permission checkboxes will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Assign Roles Modal -->
    <div class="modal fade" id="bulkAssignRolesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="bulk-assign-roles-form" action="{{ route('admin.apps.hr.roles.bulkAssignRoles') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Bulk Assign Roles</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Selected Users (<span id="selected-users-count">0</span>)</label>
                            <div id="selected-users-list" class="alert alert-light p-2" style="max-height: 150px; overflow-y: auto;">
                                <em class="text-muted">No users selected</em>
                            </div>
                            <input type="hidden" name="user_ids" id="bulk-user-ids">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Assign Roles</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                <input type="text" id="bulk-roles-search" class="form-control border-0 bg-light" placeholder="Search roles...">
                            </div>
                            <div class="card border-light">
                                <div class="card-body p-2" style="max-height: 250px; overflow-y: auto;">
                                    <div id="bulk-roles-list" class="row g-2">
                                        <!-- Roles will be populated here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="overwrite-roles" name="overwrite" value="1">
                                <label class="form-check-label" for="overwrite-roles">
                                    Replace existing roles (otherwise will add to existing roles)
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Assign Roles</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Assign Permissions Modal -->
    <div class="modal fade" id="bulkAssignPermissionsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="bulk-assign-permissions-form" action="{{ route('admin.apps.hr.roles.bulkAssignPermissions') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Bulk Assign Direct Permissions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Selected Users (<span id="selected-users-count-perms">0</span>)</label>
                            <div id="selected-users-list-perms" class="alert alert-light p-2" style="max-height: 150px; overflow-y: auto;">
                                <em class="text-muted">No users selected</em>
                            </div>
                            <input type="hidden" name="user_ids" id="bulk-user-ids-perms">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Assign Permissions</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                <input type="text" id="bulk-permissions-search" class="form-control border-0 bg-light" placeholder="Search permissions...">
                            </div>
                            <div class="card border-light">
                                <div class="card-body p-2" style="max-height: 250px; overflow-y: auto;">
                                    <div id="bulk-permissions-container">
                                        <!-- Permission categories will be dynamically populated -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="overwrite-permissions" name="overwrite" value="1">
                                <label class="form-check-label" for="overwrite-permissions">
                                    Replace existing direct permissions (otherwise will add to existing permissions)
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Assign Permissions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usersList = document.getElementById('users-list');
            const userSearch = document.getElementById('user-search');
            const userItems = document.querySelectorAll('.user-item');
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            const selectAllUsers = document.getElementById('select-all-users');
            const bulkActions = document.querySelector('.bulk-actions');
            const userInfoPlaceholder = document.getElementById('user-info-placeholder');
            const userInfo = document.getElementById('user-info');
            const userAvatar = document.getElementById('user-avatar');
            const userName = document.getElementById('user-name');
            const userDetails = document.getElementById('user-details');
            const noUserSelected = document.getElementById('no-user-selected');
            const rolesPermissionsContent = document.getElementById('roles-permissions-content');
            const roleSearch = document.getElementById('role-search');
            const rolesList = document.getElementById('roles-list');
            const permissionSearch = document.getElementById('permission-search');
            const permissionsContainer = document.getElementById('permissions-container');

            const roles = @json($roles);

            const allPermissions = @json($permissions);
            const permissionGroups = {};

            allPermissions.forEach(permission => {
                const nameParts = permission.name.split(' ');
                const category = nameParts[nameParts.length - 1];

                if (!permissionGroups[category]) {
                    permissionGroups[category] = [];
                }

                permissionGroups[category].push(permission);
            });

            userSearch.addEventListener('keyup', debounce(async function() {
                const searchValue = this.value.trim().toLowerCase();
                const officeId = document.getElementById('office-filter').value;
                const designationId = document.getElementById('designation-filter').value;

                if (searchValue.length === 0 && !officeId && !designationId) {
                    usersList.innerHTML = '<div class="text-center py-3 text-muted">Start typing to search users</div>';
                    return;
                }
                usersList.innerHTML = '<div class="text-center py-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
                const data = await fetchRequest(`/admin/apps/hr/roles/search-users?search=${encodeURIComponent(searchValue)}&office_id=${officeId}&designation_id=${designationId}`);
                if (data) {
                    updateUsersList(data.users);
                } else {
                    usersList.innerHTML = '<div class="text-center py-3 text-danger">Failed to load users</div>';
                }
            }, 300));

            function updateUsersList(users) {
                if (users.length === 0) {
                    usersList.innerHTML = '<div class="text-center py-3 text-muted">No users found</div>';
                    return;
                }

                usersList.innerHTML = '';

                users.forEach(user => {
                    const userItem = document.createElement('div');
                    userItem.className = 'list-group-item list-group-item-action d-flex align-items-center user-item p-2';
                    userItem.dataset.userId = user.id;

                    userItem.innerHTML = `
                        <div class="form-check me-2">
                            <input class="form-check-input user-checkbox" type="checkbox" value="${user.id}" id="user-${user.id}">
                        </div>
                        <div class="d-flex align-items-center flex-grow-1">
                            <img src="${user.avatar || '{{ asset("admin/images/default-avatar.jpg") }}'}" 
                                class="rounded-circle me-2" width="32" height="32">
                            <div>
                                <h6 class="mb-0">${user.name}</h6>
                                <small class="text-muted">
                                    ${user.designation || 'No designation'} 
                                    <span class="text-secondary">&bull;</span> 
                                    ${user.office || 'No office'}
                                </small>
                            </div>
                        </div>
                    `;
                    usersList.appendChild(userItem);
                });

                document.querySelectorAll('.user-item').forEach(item => {
                    item.addEventListener('click', function(e) {
                        if (e.target.type === 'checkbox') return;
                        const userId = this.dataset.userId;
                        loadUserRolesAndPermissions(userId);
                    });
                });

                document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateBulkActions();
                        const allChecked = Array.from(document.querySelectorAll('.user-checkbox')).every(cb => cb.checked);
                        const someChecked = Array.from(document.querySelectorAll('.user-checkbox')).some(cb => cb.checked);
                        selectAllUsers.checked = allChecked;
                        selectAllUsers.indeterminate = someChecked && !allChecked;
                    });
                });
            }

            userItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    if (e.target.type === 'checkbox') return;

                    const userId = this.dataset.userId;
                    loadUserRolesAndPermissions(userId);
                });
            });

            selectAllUsers.addEventListener('change', function() {
                const isChecked = this.checked;
                document.querySelectorAll('#users-list .user-checkbox').forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                updateBulkActions();
            });

            userCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateBulkActions();

                    const allChecked = Array.from(userCheckboxes).every(cb => cb.checked);
                    const someChecked = Array.from(userCheckboxes).some(cb => cb.checked);

                    selectAllUsers.checked = allChecked;
                    selectAllUsers.indeterminate = someChecked && !allChecked;
                });
            });

            function updateBulkActions() {
                const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked'));
                if (selectedUsers.length > 0) {
                    bulkActions.style.display = '';

                    document.getElementById('selected-users-count').textContent = selectedUsers.length;
                    document.getElementById('selected-users-count-perms').textContent = selectedUsers.length;

                    const userIds = selectedUsers.map(cb => cb.value);
                    document.getElementById('bulk-user-ids').value = JSON.stringify(userIds);
                    document.getElementById('bulk-user-ids-perms').value = JSON.stringify(userIds);

                    const usersList = document.getElementById('selected-users-list');
                    const usersListPerms = document.getElementById('selected-users-list-perms');

                    usersList.innerHTML = '';
                    usersListPerms.innerHTML = '';

                    selectedUsers.forEach(cb => {
                        const userItem = cb.closest('.user-item');
                        const userName = userItem.querySelector('h6').textContent;

                        const userBadge = document.createElement('span');
                        userBadge.className = 'badge bg-light text-dark me-1 mb-1';
                        userBadge.textContent = userName;

                        usersList.appendChild(userBadge.cloneNode(true));
                        usersListPerms.appendChild(userBadge);
                    });
                } else {
                    bulkActions.style.display = 'none';
                    document.getElementById('selected-users-count').textContent = '0';
                    document.getElementById('selected-users-count-perms').textContent = '0';
                    document.getElementById('selected-users-list').innerHTML = '<em class="text-muted">No users selected</em>';
                    document.getElementById('selected-users-list-perms').innerHTML = '<em class="text-muted">No users selected</em>';
                }
            }

            async function loadUserRolesAndPermissions(userId) {
                userInfoPlaceholder.style.display = 'none';
                noUserSelected.style.display = 'none';
                rolesPermissionsContent.style.display = 'none';
                userItems.forEach(item => {
                    item.classList.remove('active', 'bg-light');
                });
                const selectedUserItem = document.querySelector(`.user-item[data-user-id="${userId}"]`);
                if (selectedUserItem) {
                    selectedUserItem.classList.add('active', 'bg-light');
                }
                const data = await fetchRequest(`/admin/apps/hr/roles/${userId}/data`);
                if (data) {
                    const user = data.user;
                    const userRoles = data.roles;
                    const userPermissions = data.permissions;

                    userAvatar.src = user.avatar || '{{ asset("admin/images/default-avatar.jpg") }}';
                    userName.textContent = user.name;
                    userDetails.textContent = `${user.designation || 'No designation'} • ${user.office || 'No office'}`;

                    populateRoles(roles, userRoles);
                    populatePermissions(permissionGroups, userPermissions);

                    userInfo.style.display = '';
                    rolesPermissionsContent.style.display = '';
                } else {
                    noUserSelected.style.display = '';
                }
            }

            function populateRoles(allRoles, userRoles) {
                rolesList.innerHTML = '';
                allRoles.forEach(role => {
                    const hasRole = userRoles.some(r => r.id === role.id);
                    const roleCard = document.createElement('div');
                    roleCard.className = 'col-md-6';
                    roleCard.innerHTML = `
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                    <label class="form-check-label" for="role-${role.id}">
                                        ${role.name}
                                    </label>
                                    <input class="form-check-input role-toggle" type="checkbox" 
                                        data-role-id="${role.id}" id="role-${role.id}" 
                                        ${hasRole ? 'checked' : ''}>
                                </div>
                            </div>
                        </div>
                    `;
                    rolesList.appendChild(roleCard);
                });

                document.querySelectorAll('.role-toggle').forEach(toggle => {
                    toggle.addEventListener('change', function() {
                        const roleId = this.dataset.roleId;
                        const userId = document.querySelector('.user-item.active').dataset.userId;
                        const hasRole = this.checked;

                        updateUserRole(userId, roleId, hasRole);
                    });
                });

                roleSearch.addEventListener('keyup', function() {
                    const searchValue = this.value.toLowerCase();
                    document.querySelectorAll('#roles-list .card').forEach(card => {
                        const roleName = card.querySelector('label').textContent.toLowerCase();
                        if (roleName.includes(searchValue)) {
                            card.closest('.col-md-6').style.display = '';
                        } else {
                            card.closest('.col-md-6').style.display = 'none';
                        }
                    });
                });
            }

            function populatePermissions(groups, userPermissions) {
                permissionsContainer.innerHTML = '';
                Object.keys(groups).sort().forEach(category => {
                    const categoryGroup = document.createElement('div');
                    categoryGroup.className = 'permission-category mb-3';

                    const categoryHeader = document.createElement('h6');
                    categoryHeader.className = 'mb-2 border-bottom pb-1';
                    categoryHeader.textContent = category.charAt(0).toUpperCase() + category.slice(1);
                    categoryGroup.appendChild(categoryHeader);

                    const permissionsGrid = document.createElement('div');
                    permissionsGrid.className = 'row g-2';
                    groups[category].forEach(permission => {
                        const hasPermission = userPermissions.some(p => p.id === permission.id);

                        const permissionCol = document.createElement('div');
                        permissionCol.className = 'col-md-6';
                        permissionCol.innerHTML = `
                            <div class="form-check form-switch">
                                <input class="form-check-input permission-toggle" type="checkbox" 
                                    data-permission-id="${permission.id}" id="perm-${permission.id}" 
                                    ${hasPermission ? 'checked' : ''}>
                                <label class="form-check-label" for="perm-${permission.id}">
                                    ${permission.name}
                                </label>
                            </div>
                        `;
                        permissionsGrid.appendChild(permissionCol);
                    });

                    categoryGroup.appendChild(permissionsGrid);
                    permissionsContainer.appendChild(categoryGroup);
                });

                document.querySelectorAll('.permission-toggle').forEach(toggle => {
                    toggle.addEventListener('change', function() {
                        const permissionId = this.dataset.permissionId;
                        const userId = document.querySelector('.user-item.active').dataset.userId;
                        const hasPermission = this.checked;

                        updateUserPermission(userId, permissionId, hasPermission);
                    });
                });

                permissionSearch.addEventListener('keyup', function() {
                    const searchValue = this.value.toLowerCase();

                    document.querySelectorAll('.permission-category').forEach(category => {
                        const categoryName = category.querySelector('h6').textContent.toLowerCase();
                        const permissionItems = category.querySelectorAll('.form-check');

                        let hasVisibleItems = false;

                        permissionItems.forEach(item => {
                            const permissionName = item.querySelector('label').textContent.toLowerCase();

                            if (permissionName.includes(searchValue) || categoryName.includes(searchValue)) {
                                item.closest('.col-md-6').style.display = '';
                                hasVisibleItems = true;
                            } else {
                                item.closest('.col-md-6').style.display = 'none';
                            }
                        });

                        category.style.display = hasVisibleItems ? '' : 'none';
                    });
                });
            }

            async function updateUserRole(userId, roleId, hasRole) {
                const url = `/admin/apps/hr/roles/users/${userId}/roles/${roleId}`;
                const method = hasRole ? 'POST' : 'DELETE';
                const result = await fetchRequest(url, method);
                if (!result) {
                    const toggle = document.querySelector(`.role-toggle[data-role-id="${roleId}"]`);
                    toggle.checked = !hasRole;
                }
            }

            async function updateUserPermission(userId, permissionId, hasPermission) {
                const url = `/admin/apps/hr/roles/users/${userId}/permissions/${permissionId}`;
                const method = hasPermission ? 'POST' : 'DELETE';
                const result = await fetchRequest(url, method);
                if (!result) {
                    const toggle = document.querySelector(`.permission-toggle[data-permission-id="${permissionId}"]`);
                    toggle.checked = !hasPermission;
                }
            }

            function populateNewRolePermissions() {
                const container = document.getElementById('new-role-permissions-container');
                container.innerHTML = '';
                Object.keys(permissionGroups).sort().forEach(category => {
                    const categoryGroup = document.createElement('div');
                    categoryGroup.className = 'permission-category mb-3';
                    const categoryHeader = document.createElement('h6');
                    categoryHeader.className = 'mb-2 border-bottom pb-1';
                    categoryHeader.textContent = category.charAt(0).toUpperCase() + category.slice(1);
                    categoryGroup.appendChild(categoryHeader);
                    const permissionsGrid = document.createElement('div');
                    permissionsGrid.className = 'row g-2';

                    permissionGroups[category].forEach(permission => {
                        const permissionCol = document.createElement('div');
                        permissionCol.className = 'col-md-6';
                        permissionCol.innerHTML = `
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                    name="permissions[]" value="${permission.id}" 
                                    id="new-perm-${permission.id}">
                                <label class="form-check-label" for="new-perm-${permission.id}">
                                    ${permission.name}
                                </label>
                            </div>
                        `;
                        permissionsGrid.appendChild(permissionCol);
                    });
                    categoryGroup.appendChild(permissionsGrid);
                    container.appendChild(categoryGroup);
                });

                // Permission search for new role modal
                document.getElementById('new-role-permission-search').addEventListener('keyup', function() {
                    const searchValue = this.value.toLowerCase();
                    document.querySelectorAll('#new-role-permissions-container .permission-category').forEach(category => {
                        const categoryName = category.querySelector('h6').textContent.toLowerCase();
                        const permissionItems = category.querySelectorAll('.form-check');
                        let hasVisibleItems = false;

                        permissionItems.forEach(item => {
                            const permissionName = item.querySelector('label').textContent.toLowerCase();
                            if (permissionName.includes(searchValue) || categoryName.includes(searchValue)) {
                                item.closest('.col-md-6').style.display = '';
                                hasVisibleItems = true;
                            } else {
                                item.closest('.col-md-6').style.display = 'none';
                            }
                        });
                        category.style.display = hasVisibleItems ? '' : 'none';
                    });
                });
            }

            function populateBulkRoles() {
                const container = document.getElementById('bulk-roles-list');
                container.innerHTML = '';
                roles.forEach(role => {
                    const roleCol = document.createElement('div');
                    roleCol.className = 'col-md-6';
                    roleCol.innerHTML = `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                               name="roles[]" value="${role.id}" 
                               id="bulk-role-${role.id}">
                        <label class="form-check-label" for="bulk-role-${role.id}">
                            ${role.name}
                        </label>
                    </div>
                `;
                    container.appendChild(roleCol);
                });

                document.getElementById('bulk-roles-search').addEventListener('keyup', function() {
                    const searchValue = this.value.toLowerCase();
                    document.querySelectorAll('#bulk-roles-list .form-check').forEach(item => {
                        const roleName = item.querySelector('label').textContent.toLowerCase();
                        if (roleName.includes(searchValue)) {
                            item.closest('.col-md-6').style.display = '';
                        } else {
                            item.closest('.col-md-6').style.display = 'none';
                        }
                    });
                });
            }

            function populateBulkPermissions() {
                const container = document.getElementById('bulk-permissions-container');
                container.innerHTML = '';
                Object.keys(permissionGroups).sort().forEach(category => {
                    const categoryGroup = document.createElement('div');
                    categoryGroup.className = 'permission-category mb-3';
                    const categoryHeader = document.createElement('h6');
                    categoryHeader.className = 'mb-2 border-bottom pb-1';
                    categoryHeader.textContent = category.charAt(0).toUpperCase() + category.slice(1);
                    categoryGroup.appendChild(categoryHeader);
                    const permissionsGrid = document.createElement('div');
                    permissionsGrid.className = 'row g-2';

                    permissionGroups[category].forEach(permission => {
                        const permissionCol = document.createElement('div');
                        permissionCol.className = 'col-md-6';
                        permissionCol.innerHTML = `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" 
                                   name="permissions[]" value="${permission.id}" 
                                   id="bulk-perm-${permission.id}">
                            <label class="form-check-label" for="bulk-perm-${permission.id}">
                                ${permission.name}
                            </label>
                        </div>
                    `;
                        permissionsGrid.appendChild(permissionCol);
                    });

                    categoryGroup.appendChild(permissionsGrid);
                    container.appendChild(categoryGroup);
                });

                document.getElementById('bulk-permissions-search').addEventListener('keyup', function() {
                    const searchValue = this.value.toLowerCase();
                    document.querySelectorAll('#bulk-permissions-container .permission-category').forEach(category => {
                        const categoryName = category.querySelector('h6').textContent.toLowerCase();
                        const permissionItems = category.querySelectorAll('.form-check');
                        let hasVisibleItems = false;
                        permissionItems.forEach(item => {
                            const permissionName = item.querySelector('label').textContent.toLowerCase();
                            if (permissionName.includes(searchValue) || categoryName.includes(searchValue)) {
                                item.closest('.col-md-6').style.display = '';
                                hasVisibleItems = true;
                            } else {
                                item.closest('.col-md-6').style.display = 'none';
                            }
                        });
                        category.style.display = hasVisibleItems ? '' : 'none';
                    });
                });
            }

            document.getElementById('filter-btn').addEventListener('click', async function() {
                const officeId = document.getElementById('office-filter').value;
                const designationId = document.getElementById('designation-filter').value;
                const data = await fetchRequest(`/admin/apps/hr/roles/filter-users?office_id=${officeId}&designation_id=${designationId}`);
                if (data) {
                    usersList.innerHTML = '';
                    data.users.forEach(user => {
                        const userItem = document.createElement('div');
                        userItem.className = 'list-group-item list-group-item-action d-flex align-items-center user-item p-2';
                        userItem.dataset.userId = user.id;
                        userItem.innerHTML = `
                        <div class="form-check me-2">
                            <input class="form-check-input user-checkbox" type="checkbox" value="${user.id}" id="user-${user.id}">
                        </div>
                        <div class="d-flex align-items-center flex-grow-1">
                            <img src="${user.avatar || '{{ asset("admin/images/default-avatar.jpg") }}'}" 
                                class="rounded-circle me-2" width="32" height="32">
                            <div>
                                <h6 class="mb-0">${user.name}</h6>
                                <small class="text-muted">
                                    ${user.designation || 'No designation'} 
                                    <span class="text-secondary">&bull;</span> 
                                    ${user.office || 'No office'}
                                </small>
                            </div>
                        </div>
                        `;
                        usersList.appendChild(userItem);
                    });

                    document.querySelectorAll('.user-item').forEach(item => {
                        item.addEventListener('click', function(e) {
                            if (e.target.type === 'checkbox') return;
                            const userId = this.dataset.userId;
                            loadUserRolesAndPermissions(userId);
                        });
                    });

                    document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            updateBulkActions();
                            const allChecked = Array.from(document.querySelectorAll('.user-checkbox')).every(cb => cb.checked);
                            const someChecked = Array.from(document.querySelectorAll('.user-checkbox')).some(cb => cb.checked);
                            selectAllUsers.checked = allChecked;
                            selectAllUsers.indeterminate = someChecked && !allChecked;
                        });
                    });
                }
            });

            document.getElementById('newRoleModal').addEventListener('show.bs.modal', function() {
                populateNewRolePermissions();
            });

            document.getElementById('bulkAssignRolesModal').addEventListener('show.bs.modal', function() {
                populateBulkRoles();
            });

            document.getElementById('bulkAssignPermissionsModal').addEventListener('show.bs.modal', function() {
                populateBulkPermissions();
            });

            document.getElementById('create-role-form').addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const jsonData = {};
                formData.forEach((value, key) => {
                    if (key === 'permissions[]') {
                        if (!jsonData.permissions) jsonData.permissions = [];
                        jsonData.permissions.push(value);
                    } else {
                        jsonData[key] = value;
                    }
                });
                const result = await fetchRequest(this.action, 'POST', jsonData);
                if (result) {
                    bootstrap.Modal.getInstance(document.getElementById('newRoleModal')).hide();
                    if (document.querySelector('.user-item.active')) {
                        const userId = document.querySelector('.user-item.active').dataset.userId;
                        loadUserRolesAndPermissions(userId);
                    }
                    roles.push(result.role);
                }
            });

            document.getElementById('bulk-assign-roles-form').addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const result = await fetchRequest(this.action, 'POST', formData);
                if (result) {
                    bootstrap.Modal.getInstance(document.getElementById('bulkAssignRolesModal')).hide();

                    const activeUser = document.querySelector('.user-item.active');
                    if (activeUser) {
                        loadUserRolesAndPermissions(activeUser.dataset.userId);
                    }
                }
            });

            document.getElementById('bulk-assign-permissions-form').addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const result = await fetchRequest(this.action, 'POST', formData);
                if (result) {
                    bootstrap.Modal.getInstance(document.getElementById('bulkAssignPermissionsModal')).hide();
                    const activeUser = document.querySelector('.user-item.active');
                    if (activeUser) {
                        loadUserRolesAndPermissions(activeUser.dataset.userId);
                    }
                }
            });
        });

    </script>
    @endpush
</x-hr-layout>
