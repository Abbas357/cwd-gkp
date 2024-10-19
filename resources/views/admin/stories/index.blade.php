<x-app-layout title="E-Standardization">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">E-Standardization</li>
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

    <table id="stories-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Title</th>
                <th scope="col" class="p-3">Image</th>
                <th scope="col" class="p-3">Posted By</th>
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
                        , searchBuilderType: "null"
                    }
                    , {
                        data: "user"
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
                , defaultOrderColumn: 11
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                }]
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
            
        });

    </script>
    @endpush
</x-app-layout>
