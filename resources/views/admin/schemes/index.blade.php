<x-app-layout title="Schemes">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Schemes</li>
    </x-slot>

    <div class="card-header mb-3">
        <div class="row">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="year">Year</label>
                    <select class="form-select form-select-md filter-field" id="year" name="year">
                        <option value="">Select Year</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="scheme_code">Scheme Code</label>
                    <input type="text" class="form-control filter-field" id="scheme_code" name="scheme_code" placeholder="Scheme Code">
                </div>
            </div>
        </div>
    </div>

    <table id="schemes-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Name</th>
                <th scope="col" class="p-3">Commencement Date</th>
                <th scope="col" class="p-3">Total Cost (Millions)</th>
                <th scope="col" class="p-3">District</th>
                <th scope="col" class="p-3">Chief Engineer</th>
                <th scope="col" class="p-3">Progress Percentage</th>
                <th scope="col" class="p-3">Year of Completion</th>
                <th scope="col" class="p-3">Uploaded By</th>
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
        function dynamicFilterNavigator(config) {
            const { table, dataTableUrl, filterSelector } = config;

            function buildQueryParams(params) {
                if (!params) return "";
                const queryParams = Object.entries(params)
                    .filter(([key, value]) => value !== undefined && value !== "")
                    .map(
                        ([key, value]) =>
                            `${encodeURIComponent(key)}=${encodeURIComponent(value)}`
                    )
                    .join("&");
                return queryParams ? "?" + queryParams : "";
            }

            function updateDataTableURL(params) {
                const queryParams = buildQueryParams(params);
                const tableFullUrl = dataTableUrl + queryParams;
                table.ajax.url(tableFullUrl).load();
            }

            function getFilterValues() {
                const params = {};
                $(filterSelector).each(function () {
                    const key = $(this).attr("name");
                    const value = $(this).val();
                    if (key) {
                        params[key] = value;
                    }
                });
                return params;
            }

            $(filterSelector).on("change keyup", function () {
                const params = getFilterValues();
                updateDataTableURL(params);
            });

            updateDataTableURL(getFilterValues());
        }

        $(document).ready(function() {
            var table = initDataTable('#schemes-datatable', {
                ajaxUrl: "{{ route('admin.development_projects.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "commencement_date"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "total_cost"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "district"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "chief_engineer"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "progress_percentage"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "year_of_completion"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "uploaded_by"
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
                    targets: [0,3,5,6,7]
                    , visible: false
                }]
                , customButton: {
                    text: `<span class="symbol-container fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Dev. Project</span>`
                    , action: function(e, dt, node, config) {
                        window.location.href = "{{ route('admin.development_projects.create') }}";
                    }
                , }
            });

            dynamicFilterNavigator({
                table: table,
                dataTableUrl: "{{ route('admin.development_projects.index') }}",
                filterSelector: ".filter-field",
            });

            $("#schemes-datatable").on('click', '.publish-btn', async function() {
                const dev_projectId = $(this).data("id");
                const message = $(this).data("type");
                const url = "{{ route('admin.development_projects.publish', ':id') }}".replace(':id', dev_projectId);

                const result = await confirmAction(`Do you want to ${message} this Project?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#schemes-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#schemes-datatable").on('click', '.archive-btn', async function() {
                const dev_projectId = $(this).data("id");
                const url = "{{ route('admin.development_projects.archive', ':id') }}".replace(':id', dev_projectId);

                const result = await confirmAction(`Do you want to archive this Project?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#schemes-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#schemes-datatable").on('click', '.delete-btn', async function() {
                const projectsId = $(this).data("id");
                const url = "{{ route('admin.development_projects.destroy', ':id') }}".replace(':id', projectsId);

                const result = await confirmAction(`Do you want to delete this projects?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#schemes-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $('#schemes-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.development_projects.detail', ':id') }}"
                , btnSelector: '.view-btn'
                , title: 'Schemes Details'
                , modalSize: 'lg'
            , });

        });

    </script>
    @endpush
</x-app-layout>
