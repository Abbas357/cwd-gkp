<x-app-layout title="Vehicles">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Vehicles</li>
    </x-slot>

    <table id="vehicles-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Name</th>
                <th scope="col" class="p-3">Designation</th>
                <th scope="col" class="p-3">Office</th>
                <th scope="col" class="p-3">Office Type</th>
                <th scope="col" class="p-3">Created At</th>
                <th scope="col" class="p-3">Updated At</th>
                <th scope="col" class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <!--end row-->
    @push('script')
    <script src="{{ asset('admin/plugins/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/col-resizable.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = initDataTable('#vehicles-datatable', {
                ajaxUrl: "{{ route('admin.vehicle-users.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "designation"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "office"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "office_type"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "created_at"
                        , searchBuilderType: "date"
                    }
                    , {
                        data: "updated_at"
                        , searchBuilderType: "date"
                    }
                    , {
                        data: 'action'
                        , orderable: false
                        , searchable: false
                        , type: "html"
                    }
                ]
                , defaultOrderColumn: 9
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                }]
                , customButton: {
                    text: `<span class="symbol-container fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add User</span>`
                    , action: function(e, dt, node, config) {
                        window.location.href = "{{ route('admin.vehicle-users.create') }}";
                    },
                }
            });

            $("#vehicles-datatable").on('click', '.delete-btn', async function() {
                const userId = $(this).data("id");
                const url = "{{ route('admin.vehicle-users.destroy', ':id') }}".replace(':id', userId);

                const result = await confirmAction(`Do you want to delete this user?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#vehicles-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $('#vehicles-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.vehicle-users.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'User Details',
                modalSize: 'lg',
            });
            
        });

    </script>
    @endpush
</x-app-layout>
