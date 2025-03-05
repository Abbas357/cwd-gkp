<x-app-layout title="Stories">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Stories</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="not-published-tab" class="nav-link" data-bs-toggle="tab" href="#not-published">Not Published</a>
            </li>
            <li class="nav-item">
                <a id="published-tab" class="nav-link" data-bs-toggle="tab" href="#published">Published</a>
            </li>
        </ul>
    </div>

    <div class="table-responsive">
        <table id="stories-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Title</th>
                    <th scope="col" class="p-3">Image</th>
                    <th scope="col" class="p-3">Posted By</th>
                    <th scope="col" class="p-3">Views</th>
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
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = initDataTable('#stories-datatable', {
                ajaxUrl: "{{ route('admin.stories.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "title"
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
                        data: "views"
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
                , defaultOrderColumn: 5
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                }]
                , pageLength: 25
                , customButton: {
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Story</span>`
                    , action: function(e, dt, node, config) {
                        pushStateModal({
                            fetchUrl: "{{ route('admin.stories.create') }}"
                            , btnSelector: '.create-btn'
                            , title: 'Add Story'
                            , actionButtonName: 'Add Story'
                            , modalSize: 'lg'
                            , includeForm: true
                            , formAction: "{{ route('admin.stories.store') }}"
                            , modalHeight: '45vh'
                            , hash: false
                        , }).then((modal) => {
                            pushStateModalFormSubmission(modal, table);
                        });
                    },
                }
            });

            $("#stories-datatable").on('click', '.publish-btn', async function() {
                const storyId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.stories.publish', ':id') }}".replace(':id', storyId);

                const result = await confirmAction(`Do you want to ${message} this story?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#stories-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#stories-datatable").on('click', '.delete-btn', async function() {
                const storyId = $(this).data("id");
                const url = "{{ route('admin.stories.destroy', ':id') }}".replace(':id', storyId);

                const result = await confirmAction('Do you want to delete this story?');

                if (result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#stories-datatable").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.stories.index') }}"
                , tabToHashMap: {
                    "#not-published-tab": '#not-published'
                    , "#published-tab": '#published'
                , }
                , hashToParamsMap: {
                    '#not-published': {
                        published: 0
                    }
                    , '#published': {
                        published: 1
                    }
                , }
                , defaultHash: '#not-published'
            });

            if (new URLSearchParams(window.location.search).get("create") === "true") {
                document.querySelector(".create-btn")?.click();
            }
            
        });

    </script>
    @endpush
</x-app-layout>
