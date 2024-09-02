<x-app-layout>
    @push('style')
    <link href="{{ asset('plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Users</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a id="active-tab" class="nav-link" data-bs-toggle="tab" href="#active">Active</a>
            </li>
            <li class="nav-item">
                <a id="inactive-tab" class="nav-link" data-bs-toggle="tab" href="#inactive">In Active</a>
            </li>
        </ul>
    </div>

    <table id="users-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Name</th>
                <th scope="col" class="p-3">Email</th>
                <th scope="col" class="p-3">Mobile Number</th>
                <th scope="col" class="p-3">Landline Number</th>
                <th scope="col" class="p-3">Designation</th>
                <th scope="col" class="p-3">CNIC</th>
                <th scope="col" class="p-3">Office</th>
                <th scope="col" class="p-3">Password Updated</th>
                <th scope="col" class="p-3">Active</th>
                <th scope="col" class="p-3">Created At</th>
                <th scope="col" class="p-3">Updated At</th>
                <th scope="col" class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>    

    <div class="modal fade" id="userEditModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Loading...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="loading-spinner text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="user-details" style="display: none;">
                        <!-- User details will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    
    <!--end row-->
    @push('script')
    <script src="{{ asset('plugins/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/col-resizable.js') }}"></script>
        <script>
            $(document).ready(function() {
                var table = initDataTable('#users-datatable', {
                    ajaxUrl: "{{ route('users.index') }}",
                    columns: [
                        { data: "id", searchBuilderType: "num" },
                        { data: "name", searchBuilderType: "string" },
                        { data: "email", searchBuilderType: "string" },
                        { data: "mobile_number", searchBuilderType: "string" },
                        { data: "landline_number", searchBuilderType: "string" },
                        { data: "designation", searchBuilderType: "string" },
                        { data: "cnic", searchBuilderType: "string" },
                        { data: "office", searchBuilderType: "string" },
                        { data: "password_updated_at", searchBuilderType: "date" },
                        { data: "is_active", searchBuilderType: "string" },
                        { data: "created_at", searchBuilderType: "date" },
                        { data: "updated_at", searchBuilderType: "date" },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false,
                            type: "html"
                        }
                    ],
                    defaultOrderColumn: 9,
                    defaultOrderDirection: 'desc',
                    columnDefs: [{
                        targets: [7,8,9],
                        visible: false
                    }]
                });

                hashTabsNavigator({
                    table: table,
                    dataTableUrl: "{{ route('users.index') }}",
                    tabToHashMap: {
                        "#active-tab": '#active',
                        "#inactive-tab": '#inactive'
                    },
                    hashToParamsMap: {
                        '#active': { active: 1 },
                        '#inactive': { active: 0 }
                    },
                    defaultHash: '#active'
                });

                $("#users-datatable").on('click', '.delete-btn', async function() {
                    const userId = $(this).data("id");
                    const url = "{{ route('users.destroy', ':id') }}".replace(':id', userId);

                    const result = await confirmAction('Do you want to delete this user?');

                    if (result.isConfirmed) {
                        const success = await fetchRequest(url, 'DELETE');
                        if (success) {
                            $("#users-datatable").DataTable().ajax.reload();
                        }
                    }
                });

                $('#users-datatable').colResizable(
                { 
                    liveDrag: true,
                    resizeMode:'overflow',
                    postbackSafe:true,
                    useLocalStorage: true,
                    gripInnerHtml: "<div class='grip'></div>",
                    draggingClass:"dragging",
                });


                $(document).on('click', '.edit-btn', async function() {
                    const userId = $(this).data('id');
                    const url = "{{ route('users.show', ':id') }}".replace(':id', userId);

                    $('#userEditModal').modal('show');
                    $('#userEditModal .loading-spinner').show();
                    $('#userEditModal .user-details').hide();

                    const user = await fetchRequest(url);

                    if (user) {
                        $('#userEditModal .modal-title').text('Edit User (' + user.name + ')');
                        $('#userEditModal .modal-body').html(`
                            <p><strong>Name:</strong> ${user.name}</p>
                            <p><strong>Email:</strong> ${user.email}</p>
                        `);
                    } else {
                        $('#userEditModal .modal-title').text('Error');
                        $('#userEditModal .user-details').html('<p>Failed to load user data.</p>');
                    }
                    $('#userEditModal .loading-spinner').hide();
                    $('#userEditModal .user-details').show();
                });
                
            });
                
        </script>
    @endpush
</x-app-layout>
