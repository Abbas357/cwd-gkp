<x-app-layout title="News">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">News</li>
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
        <table id="news-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Title</th>
                    <th scope="col" class="p-3">Category</th>
                    <th scope="col" class="p-3">Short Description</th>
                    <th scope="col" class="p-3">Attachment</th>
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
    </div>
    <!--end row-->
    @push('script')
    <script src="{{ asset('admin/plugins/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/col-resizable.js') }}"></script>
    <script src="{{ asset('admin/plugins/html2canvas/html2canvas.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = initDataTable('#news-datatable', {
                ajaxUrl: "{{ route('admin.news.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "title"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "category"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "summary"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "attachment"
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
                , defaultOrderColumn: 7
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                }]
                , pageLength: 25
                , customButton: {
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add News</span>`
                    , action: function(e, dt, node, config) {
                        pushStateModal({
                            fetchUrl: "{{ route('admin.news.create') }}"
                            , btnSelector: '.create-btn'
                            , title: 'Add News'
                            , actionButtonName: 'Add News'
                            , modalSize: 'lg'
                            , includeForm: true
                            , formAction: "{{ route('admin.news.store') }}"
                            , modalHeight: '65vh'
                            , hash: false
                        , }).then((modal) => {
                            const newsModal = $('#' + modal);
                            const updateNewsBtn = newsModal.find('button[type="submit"]');
                            newsModal.find('form').on('submit', async function(e) {
                                e.preventDefault();
                                const form = this;
                                const formData = new FormData(form);
                                const url = $(this).attr('action');
                                setButtonLoading(updateNewsBtn, true);
                                try {
                                    const result = await fetchRequest(url, 'POST', formData);
                                    if (result) {
                                        setButtonLoading(updateNewsBtn, false);
                                        newsModal.modal('hide');
                                        table.ajax.reload();
                                    }
                                } catch (error) {
                                    setButtonLoading(updateNewsBtn, false);
                                    console.error('Error during form submission:', error);
                                }
                            });
                        });
                    },
                }
            });

            $("#news-datatable").on('click', '.publish-btn', async function() {
                const newsId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.news.publish', ':id') }}".replace(':id', newsId);

                const result = await confirmAction(`Do you want to ${message} this news?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#news-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#news-datatable").on('click', '.archive-btn', async function() {
                const newsId = $(this).data("id");
                const url = "{{ route('admin.news.archive', ':id') }}".replace(':id', newsId);

                const result = await confirmAction(`Do you want to archive this news?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#news-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#news-datatable").on('click', '.delete-btn', async function() {
                const newsId = $(this).data("id");
                const url = "{{ route('admin.news.destroy', ':id') }}".replace(':id', newsId);

                const result = await confirmAction(`Do you want to delete this news?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#news-datatable").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.news.index') }}"
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

            $('#news-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.news.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'News Details',
                modalSize: 'lg',
            });
            
        });

    </script>
    @endpush
</x-app-layout>
