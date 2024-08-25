<x-app-layout>
    @push('style')
    <link href="{{ asset('plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Contractor Registrations</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a id="active-users" class="nav-link active" data-bs-toggle="tab" href="#active-users">Active Users</a>
            </li>
            <li class="nav-item">
                <a id="non-active-users" class="nav-link" data-bs-toggle="tab" href="#non-active-users">Non Active Users</a>
            </li>
        </ul>
    </div>

    <table id="users-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Name</th>
                <th scope="col" class="p-3">Email</th>
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
    <script src="{{ asset('plugins/sweetalert2@11.js') }}"></script>
        <script>
            $(document).ready(function() {
                var table = initDataTable('#users-datatable', {
                    ajaxUrl: "{{ route('users.index') }}",
                    columns: [
                        { data: "id", searchBuilderType: "num" },
                        { data: "name", searchBuilderType: "string" },
                        { data: "email", searchBuilderType: "string" },
                        { data: "created_at", searchBuilderType: "date" },
                        { data: "updated_at", searchBuilderType: "date" },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false,
                            type: "html"
                        }
                    ],
                    defaultOrderColumn: 3,
                    defaultOrderDirection: 'desc',
                    columnDefs: [{
                        targets: [4],
                        visible: false
                    }]
                });

                $("#users-datatable").on('click', '.delete-btn', function() {
                    const userId = $(this).data("id");
                    const url =  "{{ route('users.destroy', ':id') }}".replace(':id', userId);
                    confirmAction('Do you want to delete this user?').then((result) => {
                        if (result.isConfirmed) {
                            actionRequest(url, 'DELETE').then(success => {
                                if (success) $("#users-datatable").DataTable().ajax.reload();
                            });
                        }
                    });
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


                $(document).on('click', '.edit-btn', function() {
                    var userId = $(this).data('id');
                    const url =  "{{ route('users.show', ':id') }}".replace(':id', userId);

                    $('#userEditModal').modal('show');
                    $('#userEditModal .loading-spinner').show();
                    $('#userEditModal .user-details').hide();

                    fetchRequest(url, 'GET').then((user) => {
                        $('#userEditModal .modal-title').text('Edit User (' + user.name + ')');
                        $('#userEditModal .modal-body').html(`
                        <p><strong>Name:</strong> ${user.name}</p>
                        <p><strong>Email:</strong> ${user.email}</p>
                    `);
                        $('#userEditModal .loading-spinner').hide();
                        $('#userEditModal .user-details').show();
                    }).catch(error => {
                        $('#userEditModal .modal-title').text('Error');
                        $('#userEditModal .user-details').html('<p>Failed to load user data.</p>');

                        $('#userEditModal .loading-spinner').hide();
                        $('#userEditModal .user-details').show();
                    });

                });

                
            });
                
        </script>
    @endpush
</x-app-layout>
