<x-app-layout title="Comment">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Comment</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="new-tab" class="nav-link" data-bs-toggle="tab" href="#new">New</a>
            </li>
            <li class="nav-item">
                <a id="published-tab" class="nav-link" data-bs-toggle="tab" href="#published">Published</a>
            </li>
            <li class="nav-item">
                <a id="archived-tab" class="nav-link" data-bs-toggle="tab" href="#archived">Archived</a>
            </li>
        </ul>
    </div>

    <table id="comments-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Name</th>
                <th scope="col" class="p-3">Email</th>
                <th scope="col" class="p-3">Comment</th>
                <th scope="col" class="p-3">Published By</th>
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
            var table = initDataTable('#comments-datatable', {
                ajaxUrl: "{{ route('admin.comments.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "email"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "body"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "published_by"
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
                , defaultOrderColumn: 6
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                }]
            });

            $("#comments-datatable").on('click', '.publish-btn', async function() {
                const commentId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.comments.publish', ':id') }}".replace(':id', commentId);

                const result = await confirmAction(`Do you want to ${message} this comment?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#comments-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#comments-datatable").on('click', '.archive-btn', async function() {
                const commentId = $(this).data("id");
                const url = "{{ route('admin.comments.archive', ':id') }}".replace(':id', commentId);

                const result = await confirmAction(`Do you want to archive this comment?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#comments-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#comments-datatable").on('click', '.delete-btn', async function() {
                const commentId = $(this).data("id");
                const url = "{{ route('admin.comments.destroy', ':id') }}".replace(':id', commentId);

                const result = await confirmAction(`Do you want to delete this comment?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#comments-datatable").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.comments.index') }}"
                , tabToHashMap: {
                    "#new-tab": '#new'
                    , "#published-tab": '#published'
                    , "#archived-tab": '#archived'
                , }
                , hashToParamsMap: {
                    '#new': {
                        status: 'new'
                    }
                    , '#published': {
                        status: 'published'
                    }
                    , '#archived': {
                        status: 'archived'
                    }
                , }
                , defaultHash: '#new'
            });

            $('#comments-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.comments.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Comment Details',
                modalSize: 'lg',
            });
            
        });

    </script>
    @endpush
</x-app-layout>