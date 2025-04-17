<x-hr-layout title="Permissions Management">
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.hr.acl.roles.index') }}">HR</a></li>
        <li class="breadcrumb-item active" aria-current="page">Permissions</li>
    </x-slot>

    @push('style')
    <style>
        .permissions-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 10px;
            border-left: 4px solid #3b82f6;
            margin-bottom: 1.5rem;
        }
        
        .permissions-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }
        
        .permission-item {
            transition: all 0.2s;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
        }
        
        .permission-item:hover {
            background-color: #e9ecef;
        }
        
        .module-header {
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
            color: #4b5563;
            display: flex;
            align-items: center;
            text-transform: capitalize;
        }
        
        .module-header .badge {
            margin-left: 10px;
        }
        
        .permission-action {
            background: transparent;
            border: none;
            color: #ef4444;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .permission-action:hover {
            color: #b91c1c;
            transform: scale(1.1);
        }
        
        .permission-name {
            font-size: 0.9rem;
            color: #1f2937;
        }
        
        .sync-container {
            position: relative;
            margin-bottom: 20px;
        }
        
        .sync-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
        }
        
        .sync-btn:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .sync-btn::after {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.6s;
        }
        
        .sync-btn:hover::after {
            left: 100%;
        }
        
        .add-permission-form {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .permissions-search {
            margin-bottom: 20px;
        }
        
        .search-result-highlight {
            background-color: #fef3c7;
            padding: 2px;
            border-radius: 3px;
        }
        
        .empty-permissions {
            padding: 30px;
            text-align: center;
            background: #f9fafb;
            border-radius: 10px;
            color: #6b7280;
        }
    </style>
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title">Permissions Management</h4>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                                    <i class="bi bi-plus-circle me-1"></i> Add Permission
                                </button>
                                <button type="button" class="btn btn-warning sync-btn" data-bs-toggle="modal" data-bs-target="#syncPermissionsModal">
                                    <i class="bi bi-arrow-repeat me-1"></i> Sync to Default
                                </button>
                            </div>
                        </div>
                        
                        <div class="permissions-search">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" id="permissionSearch" class="form-control" placeholder="Search permissions...">
                                <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6 col-lg-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Permissions</h5>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-shield-lock fs-1 me-3"></i>
                                            <h2 class="mb-0">{{ $totalPermissions }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Module Groups</h5>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-grid-3x3-gap fs-1 me-3"></i>
                                            <h2 class="mb-0">{{ $groupedPermissions->count() }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="permissionsContainer">
                            @forelse($groupedPermissions as $module => $permissions)
                                <div class="permissions-card card">
                                    <div class="card-header">
                                        <div class="module-header">
                                            <i class="bi bi-box me-2"></i>
                                            {{ $module }}
                                            <span class="badge bg-primary ms-2">{{ $permissions->count() }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @foreach($permissions as $permission)
                                            <div class="permission-item">
                                                <div class="permission-name">{{ $permission->name }}</div>
                                                <form action="{{ route('admin.apps.hr.acl.permissions.destroy', $permission) }}" method="POST" class="d-inline-block delete-permission-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="permission-action btn-delete-permission">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="empty-permissions">
                                    <i class="bi bi-shield-slash fs-1 d-block mb-3"></i>
                                    <h5>No permissions found</h5>
                                    <p>Start by adding a new permission or sync to defaults.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Permission Modal -->
    <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPermissionModalLabel">Add New Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.apps.hr.acl.permissions.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="permissionName" class="form-label">Permission Name</label>
                            <input type="text" class="form-control" id="permissionName" name="name" required>
                            <div class="form-text">
                                Format should be: <code>action resource</code> (e.g., "create user" or "view any post")
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sync Permissions Modal -->
    <div class="modal fade" id="syncPermissionsModal" tabindex="-1" aria-labelledby="syncPermissionsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="syncPermissionsModalLabel">Reset to Default Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Warning!</strong> This action will remove all existing permissions and replace them with the default set. This cannot be undone.
                    </div>
                    <p>Are you sure you want to reset all permissions to default?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.apps.hr.acl.permissions.sync') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Reset Permissions</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Permission search functionality
            const searchInput = document.getElementById('permissionSearch');
            const clearBtn = document.getElementById('clearSearch');
            const permissionsContainer = document.getElementById('permissionsContainer');
            const permissionCards = document.querySelectorAll('.permissions-card');
            const originalContent = permissionsContainer.innerHTML;
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                if (searchTerm === '') {
                    permissionsContainer.innerHTML = originalContent;
                    initDeleteButtons();
                    return;
                }
                
                let results = [];
                let matchFound = false;
                
                permissionCards.forEach(card => {
                    const moduleHeader = card.querySelector('.module-header').textContent.trim();
                    const permissionItems = card.querySelectorAll('.permission-item');
                    let moduleMatches = [];
                    
                    permissionItems.forEach(item => {
                        const permissionName = item.querySelector('.permission-name').textContent.trim();
                        
                        if (permissionName.toLowerCase().includes(searchTerm)) {
                            const highlightedName = permissionName.replace(
                                new RegExp(searchTerm, 'gi'),
                                match => `<span class="search-result-highlight">${match}</span>`
                            );
                            
                            moduleMatches.push({
                                name: permissionName,
                                highlightedName: highlightedName,
                                id: item.querySelector('form').action.split('/').pop()
                            });
                            
                            matchFound = true;
                        }
                    });
                    
                    if (moduleMatches.length > 0) {
                        results.push({
                            module: moduleHeader,
                            matches: moduleMatches
                        });
                    }
                });
                
                if (matchFound) {
                    let html = '';
                    
                    results.forEach(result => {
                        html += `
                            <div class="permissions-card card">
                                <div class="card-header">
                                    <div class="module-header">
                                        <i class="bi bi-box me-2"></i>
                                        ${result.module}
                                        <span class="badge bg-primary ms-2">${result.matches.length}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                        `;
                        
                        result.matches.forEach(match => {
                            html += `
                                <div class="permission-item">
                                    <div class="permission-name">${match.highlightedName}</div>
                                    <form action="${window.location.pathname}/${match.id}" method="POST" class="d-inline-block delete-permission-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="permission-action btn-delete-permission">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            `;
                        });
                        
                        html += `
                                </div>
                            </div>
                        `;
                    });
                    
                    permissionsContainer.innerHTML = html;
                    initDeleteButtons();
                } else {
                    permissionsContainer.innerHTML = `
                        <div class="empty-permissions">
                            <i class="bi bi-search fs-1 d-block mb-3"></i>
                            <h5>No permissions found for "${searchTerm}"</h5>
                            <p>Try a different search term or clear the search</p>
                        </div>
                    `;
                }
            });
            
            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                permissionsContainer.innerHTML = originalContent;
                initDeleteButtons();
            });
            
            // Initialize delete confirmation
            initDeleteButtons();
            
            function initDeleteButtons() {
                document.querySelectorAll('.btn-delete-permission').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.closest('form').submit();
                            }
                        });
                    });
                });
            }
        });
    </script>
    @endpush
</x-hr-layout>