<x-app-layout title="Gallery">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Gallery</li>
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

    <div class="table-responsive">
        <table id="gallery-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Title</th>
                    <th scope="col" class="p-3">Type</th>
                    <th scope="col" class="p-3">Description</th>
                    <th scope="col" class="p-3">Items</th>
                    <th scope="col" class="p-3">Uploaded By</th>
                    <th scope="col" class="p-3">Status</th>
                    <th scope="col" class="p-3">Created At</th>
                    <th scope="col" class="p-3">Updated At</th>
                    <th scope="col" class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <!--end row-->
    @push('script')
    <script src="{{ asset('admin/plugins/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/col-resizable.js') }}"></script>
    <script src="{{ asset('admin/plugins/html2canvas/html2canvas.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = initDataTable('#gallery-datatable', {
                ajaxUrl: "{{ route('admin.gallery.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "title"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "type"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "description"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "items"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "uploaded_by"
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
                , defaultOrderColumn: 7
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                }]
                , pageLength: 25
                , customButton: {
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Gallery</span>`
                    , action: function(e, dt, node, config) {
                        pushStateModal({
                            fetchUrl: "{{ route('admin.gallery.create') }}"
                            , btnSelector: '.create-btn'
                            , title: 'Add Gallery'
                            , actionButtonName: 'Add Gallery'
                            , modalSize: 'xl'
                            , includeForm: true
                            , formAction: "{{ route('admin.gallery.store') }}"
                            , modalHeight: '75vh'
                            , hash: false
                        , }).then((modal) => {
                            pushStateModalFormSubmission(modal, table);
                        });
                    },
                }
            });

            $("#gallery-datatable").on('click', '.publish-btn', async function() {
                const galleryId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.gallery.publish', ':id') }}".replace(':id', galleryId);

                const result = await confirmAction(`Do you want to ${message} this file?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#gallery-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#gallery-datatable").on('click', '.archive-btn', async function() {
                const galleryId = $(this).data("id");
                const url = "{{ route('admin.gallery.archive', ':id') }}".replace(':id', galleryId);

                const result = await confirmAction(`Do you want to archive this file?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#gallery-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#gallery-datatable").on('click', '.delete-btn', async function() {
                const galleryId = $(this).data("id");
                const url = "{{ route('admin.gallery.destroy', ':id') }}".replace(':id', galleryId);

                const result = await confirmAction(`Do you want to delete this image?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#gallery-datatable").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.gallery.index') }}"
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

            $('#gallery-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.gallery.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Gallery Details',
                modalSize: 'lg',
            });
            
            if (new URLSearchParams(window.location.search).get("create") === "true") {
                document.querySelector(".create-btn")?.click();
            }
            
        });

    </script>
    @endpush
</x-app-layout>
