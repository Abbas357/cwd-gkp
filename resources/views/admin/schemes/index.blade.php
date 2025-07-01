<x-app-layout title="Schemes">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Schemes</li>
    </x-slot>

    <div class="inward-tabs mb-3">
        <div class="row">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="year">Year</label>
                    <select class="form-select form-select-md filter-field" name="year" id="year">
                        <option value="">Select Year</option>
                        @foreach (getYears() as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="scheme_code">Scheme Code</label>
                    <input type="text" class="form-control filter-field" id="scheme_code" name="scheme_code" placeholder="Scheme Code">
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="schemes-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">ADP Number</th>
                    <th scope="col" class="p-3">Scheme Code</th>
                    <th scope="col" class="p-3">Year</th>
                    <th scope="col" class="p-3">Scheme Name</th>
                    <th scope="col" class="p-3">Sector Name</th>
                    <th scope="col" class="p-3">Sub Sector Name</th>
                    <th scope="col" class="p-3">Local Cost</th>
                    <th scope="col" class="p-3">Foreign Cost</th>
                    <th scope="col" class="p-3">Previous Expenditure</th>
                    <th scope="col" class="p-3">Capital Allocation</th>
                    <th scope="col" class="p-3">Revenue Allocation</th>
                    <th scope="col" class="p-3">Total Allocation</th>
                    <th scope="col" class="p-3">F Allocation</th>
                    <th scope="col" class="p-3">TF</th>
                    <th scope="col" class="p-3">Revised Allocation</th>
                    <th scope="col" class="p-3">Prog Release</th>
                    <th scope="col" class="p-3">Progressive Expenditure</th>
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
                ajaxUrl: "{{ route('admin.schemes.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "adp_number"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "scheme_code"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "year"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "scheme_name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "sector_name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "sub_sector_name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "local_cost"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "foreign_cost"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "previous_expenditure"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "capital_allocation"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "revenue_allocation"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "total_allocation"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "f_allocation"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "tf"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "revised_allocation"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "prog_releases"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "progressive_exp"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: 'action'
                        , orderable: false
                        , searchable: false
                        , type: "html"
                    }
                ]
                , defaultOrderColumn: 17
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0,3,5,6,7]
                    , visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ]
                , pageLength: 25
                , customButton: {
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Sync Schemes</span>`
                    , action: function(e, dt, node, config) {
                        window.location.href = "{{ route('admin.schemes.sync') }}";
                    }
                , }
            });

            dynamicFilterNavigator({
                table: table,
                dataTableUrl: "{{ route('admin.schemes.index') }}",
                filterSelector: ".filter-field",
            });

            $('#schemes-datatable').colResizable({
                liveDrag: true,
                resizeMode: 'overflow',
                postbackSafe: true,
                useLocalStorage: true,
                gripInnerHtml: "<div class='grip'></div>",
                draggingClass: "dragging"
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.schemes.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Schemes Details',
                modalSize: 'lg',
                tableToRefresh: table,
             });

        });

    </script>
    @endpush
</x-app-layout>
