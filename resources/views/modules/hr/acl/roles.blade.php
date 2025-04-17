<x-hr-layout>
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Roles Management</li>
    </x-slot>

    <div class="wrapper">
        <div class="card shadow-sm">
            <div class="card-body">

                <form class="needs-validation" action="{{ route('admin.apps.hr.acl.roles.store') }}" method="post" novalidate>
                    @csrf
                    <div class="quick-add mb-4">
                        <div class="input-group">
                            <input type="text" class="form-control" id="name" value="{{ old('name') }}" name="name" placeholder="Role Name" required>
                            
                            <x-button type="submit" text="Add Role" />
                        </div>
                        @error('cover_photo')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </form>

                <div class="row">
                    <div class="col-md-4 border-end">
                        <h5 class="fw-bold mb-3">
                            <i class="bi bi-person-badge me-2"></i>Available Roles
                        </h5>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" id="search-roles" placeholder="Search roles...">
                        </div>
                        
                        <div class="role-list list-group" id="roles-container">
                            @foreach ($roles as $role)
                                <div class="list-group-item list-group-item-action role-item d-flex justify-content-between align-items-center" 
                                     data-role-id="{{ $role->id }}" data-role-name="{{ $role->name }}">
                                    <div>
                                        <span class="role-name">{{ $role->name }}</span>
                                        <span class="badge bg-primary rounded-pill ms-2">{{ $role->permissions->count() }}</span>
                                    </div>
                                    <div class="role-actions">
                                        <button class="btn btn-sm btn-outline-danger delete-role-btn" data-role-id="{{ $role->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                    </div>
                    
                    <div class="col-md-8">
                        <div id="no-role-selected" class="text-center py-5">
                            <i class="bi bi-arrow-left-circle fs-1 text-muted"></i>
                            <h5 class="mt-3 text-muted">Select a role to manage its permissions</h5>
                        </div>
                        
                        <div id="permissions-container" class="d-none">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">
                                    <i class="bi bi-shield-lock me-2"></i>Permissions for: 
                                    <span id="current-role-name" class="fw-bold"></span>
                                </h5>
                                <div class="spinner-border spinner-border-sm text-primary d-none" id="permission-saving-indicator" role="status">
                                    <span class="visually-hidden">Saving...</span>
                                </div>
                            </div>
                            
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" id="search-permissions" placeholder="Search permissions...">
                            </div>
                            
                            <div class="permissions-loading text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Loading permissions...</p>
                            </div>
                            
                            <div class="permissions-list mb-3 d-none" id="permissions-list">
                                <!-- Permissions will be loaded dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script>
        $(document).ready(function() {
            let selectedRoleId = null;
            function handleValidationErrors(errors) {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').addClass('d-none');
 
                if (errors) {
                    Object.keys(errors).forEach(field => {
                        const inputField = $(`#${field}`);
                        if (inputField.length) {
                            inputField.addClass('is-invalid');
                            const feedbackElement = $(`#${field}-feedback`);
                            if (feedbackElement.length) {
                                feedbackElement.removeClass('d-none').text(errors[field][0]);
                            }
                        }
                    });
                }
            }

            const urlParams = new URLSearchParams(window.location.search);
            const initialRoleId = urlParams.get('role');
            if (initialRoleId) {
                selectRole(initialRoleId);
            }
            
            $('#search-roles').on('input', function() {
                const searchTerm = $(this).val().toLowerCase().trim();
                
                $('.role-item').each(function() {
                    const roleName = $(this).data('role-name').toLowerCase();
                    if (roleName.includes(searchTerm)) {
                        $(this).removeClass('d-none');
                    } else {
                        $(this).addClass('d-none');
                    }
                });
            });

            $('#search-permissions').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();
                $('.permission-item').each(function() {
                    const permissionName = $(this).find('.permission-label').text().toLowerCase();
                    $(this).toggle(permissionName.includes(searchText));
                });
            });
            
            $(document).on('click', '.role-item', function() {
                const roleId = $(this).data('role-id');
                selectRole(roleId);
            });
            
            $(document).on('change', '.permission-checkbox', async function() {
                const permissionName = $(this).val();
                const isChecked = $(this).prop('checked');

                if (selectedRoleId) {
                    $('#permission-saving-indicator').removeClass('d-none');
                    const result = await fetchRequest(`{{ url('admin/apps/hr/acl/roles') }}/${selectedRoleId}/permission`, 'POST', { permission: permissionName, action: isChecked ? 'add' : 'remove'}, isChecked ? 'Permission added' : 'Permission removed',);
                    
                    if (result) {
                        updatePermissionCountBadge(selectedRoleId);
                    } else {
                        $(this).prop('checked', !isChecked);
                    }
                    $('#permission-saving-indicator').addClass('d-none');
                }
            });
            
            
            $(document).on('click', '.delete-role-btn', async function(e) {
                e.stopPropagation();
                const roleId = $(this).data('role-id');
                const roleName = $(this).closest('.role-item').data('role-name');
                
                const confirmation = await confirmAction(`Do you want to delete the role "${roleName}"?`);
                if (confirmation.isConfirmed) {
                    const result = await fetchRequest(`{{ url('admin/apps/hr/acl/roles') }}/${roleId}`, 'DELETE');
                    if (result) {
                        $(`.role-item[data-role-id="${roleId}"]`).remove();
                        if (selectedRoleId === roleId) {
                            resetPermissionsPanel();
                        }
                    }
                }
            });
            
            async function selectRole(roleId) {
                if (roleId === selectedRoleId) return;
                
                $('.role-item').removeClass('active');
                $(`.role-item[data-role-id="${roleId}"]`).addClass('active');
                
                $('#no-role-selected').addClass('d-none');
                $('#permissions-container').removeClass('d-none');
                $('.permissions-loading').removeClass('d-none');
                $('#permissions-list').addClass('d-none');
                
                const roleName = $(`.role-item[data-role-id="${roleId}"]`).data('role-name');
                $('#current-role-name').text(roleName);
                
                selectedRoleId = roleId;
                
                const url = new URL(window.location);
                url.searchParams.set('role', roleId);
                window.history.pushState({}, '', url);
                
                const data = await fetchRequest(`{{ url('admin/apps/hr/acl/roles') }}/${roleId}/permissions`);
                
                if (data) {
                    const role = data.role;
                    const permissions = data.permissions || [];
                    const allPermissions = data.allPermissions || [];

                    const checkedPermissions = [];
                    const uncheckedPermissions = [];
                    
                    allPermissions.forEach(permission => {
                        const isChecked = permissions.some(p => p.name === permission.name);
                        if (isChecked) {
                            checkedPermissions.push(permission);
                        } else {
                            uncheckedPermissions.push(permission);
                        }
                    });

                    checkedPermissions.sort((a, b) => a.name.localeCompare(b.name));
                    uncheckedPermissions.sort((a, b) => a.name.localeCompare(b.name));

                    const sortedPermissions = checkedPermissions.concat(uncheckedPermissions);

                    let html = '<div class="row">';
                    
                    sortedPermissions.forEach(permission => {
                        const isChecked = permissions.some(p => p.name === permission.name);
                        
                        let badgeClass = 'bg-secondary';
                        let actionType = '';
                        
                        if (permission.name.startsWith('view')) {
                            badgeClass = 'bg-info';
                            actionType = 'view';
                        } else if (permission.name.startsWith('create')) {
                            badgeClass = 'bg-success';
                            actionType = 'create';
                        } else if (permission.name.startsWith('update')) {
                            badgeClass = 'bg-primary';
                            actionType = 'update';
                        } else if (permission.name.startsWith('delete')) {
                            badgeClass = 'bg-danger';
                            actionType = 'delete';
                        } else if (permission.name.startsWith('manage')) {
                            badgeClass = 'bg-warning';
                            actionType = 'manage';
                        }
                        
                        html += `
                            <div class="col-md-6 permission-item mb-2">
                                <div class="card">
                                    <div class="card-body p-2 d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <span class="badge ${badgeClass} me-2">${actionType || 'other'}</span>
                                            <label class="permission-label mb-0" for="permission-${permission.id}">
                                                ${formatPermissionLabel(permission.name)}
                                            </label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input permission-checkbox" type="checkbox" 
                                                id="permission-${permission.id}" 
                                                value="${permission.name}" 
                                                ${isChecked ? 'checked' : ''}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                    
                    $('#permissions-list').html(html).removeClass('d-none');
                } else {
                    $('#permissions-list').html('<div class="alert alert-danger">Failed to load permissions</div>').removeClass('d-none');
                }
                
                $('.permissions-loading').addClass('d-none');
            }
            
            function formatPermissionLabel(permissionName) {
                
                return permissionName.split(' ')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');
            }
            
            function resetPermissionsPanel() {
                selectedRoleId = null;
                $('#permissions-container').addClass('d-none');
                $('#no-role-selected').removeClass('d-none');
                $('.role-item').removeClass('active');
                
                
                const url = new URL(window.location);
                url.searchParams.delete('role');
                window.history.pushState({}, '', url);
            }
            
            function updatePermissionCountBadge(roleId) {
                const count = $(`.permission-checkbox:checked`).length;
                $(`.role-item[data-role-id="${roleId}"] .badge`).text(count);
            }
            
            $('#quick-role-name').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#add-role-btn').click();
                    return false;
                }
            });
        });
    </script>
    @endpush
</x-hr-layout>