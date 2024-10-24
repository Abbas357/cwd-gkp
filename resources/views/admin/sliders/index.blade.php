<x-app-layout title="Slider">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Slider</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="draft-tab" class="nav-link" data-bs-toggle="tab" href="#draft">Draft</a>
            </li>
            <li class="nav-item">
                <a id="published-tab" class="nav-link" data-bs-toggle="tab" href="#published">Published</a>
            </li>
            <li class="nav-item">
                <a id="archived-tab" class="nav-link" data-bs-toggle="tab" href="#archived">Archived</a>
            </li>
        </ul>
    </div>

    <table id="sliders-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Title</th>
                <th scope="col" class="p-3">Short Description</th>
                <th scope="col" class="p-3">Image</th>
                <th scope="col" class="p-3">User</th>
                <th scope="col" class="p-3">Status</th>
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
    <script src="{{ asset('admin/plugins/html2canvas/html2canvas.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = initDataTable('#sliders-datatable', {
                ajaxUrl: "{{ route('admin.sliders.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "title"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "summary"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "image"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "user"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "status"
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
                , defaultOrderColumn: 0
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                }]
            });

            $("#sliders-datatable").on('click', '.publish-btn', async function() {
                const slidersId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.sliders.publish', ':id') }}".replace(':id', slidersId);

                const result = await confirmAction(`Do you want to ${message} this sliders?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#sliders-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#sliders-datatable").on('click', '.archive-btn', async function() {
                const slidersId = $(this).data("id");
                const url = "{{ route('admin.sliders.archive', ':id') }}".replace(':id', slidersId);

                const result = await confirmAction(`Do you want to archive this sliders?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#sliders-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#sliders-datatable").on('click', '.delete-btn', async function() {
                const slidersId = $(this).data("id");
                const url = "{{ route('admin.sliders.destroy', ':id') }}".replace(':id', slidersId);

                const result = await confirmAction(`Do you want to delete this sliders?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#sliders-datatable").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.sliders.index') }}"
                , tabToHashMap: {
                    "#draft-tab": '#draft'
                    , "#published-tab": '#published'
                    , "#archived-tab": '#archived'
                , }
                , hashToParamsMap: {
                    '#draft': {
                        status: 'draft'
                    }
                    , '#published': {
                        status: 'published'
                    }
                    , '#archived': {
                        status: 'archived'
                    }
                , }
                , defaultHash: '#draft'
            });

            $('#sliders-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.sliders.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Slider Details',
                modalSize: 'lg',
            });
            
        });

    </script>
    @endpush
</x-app-layout>
