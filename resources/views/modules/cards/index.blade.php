<x-module-layout title="Cards">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Cards</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="service-card-tab" class="nav-link" data-bs-toggle="tab" href="#service-card">Service Card</a>
            </li>
            <li class="nav-item">
                <a id="contractor-tab" class="nav-link" data-bs-toggle="tab" href="#contractor">Contractor Card</a>
            </li>
            <li class="nav-item">
                <a id="standardization-tab" class="nav-link" data-bs-toggle="tab" href="#standardization">Standardization Card</a>
            </li>
        </ul>
    </div>

    <div class="table-responsive">
        <table id="cards-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Type</th>
                    <th scope="col" class="p-3">Status</th>
                    <th scope="col" class="p-3">View</th>
                    <th scope="col" class="p-3">Issue Date</th>
                    <th scope="col" class="p-3">Expiry Date</th>
                    <th scope="col" class="p-3">Created At</th>
                    <th scope="col" class="p-3">Updated At</th>
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

    <script>
        $(document).ready(function() {
            var table = initDataTable('#cards-datatable', {
                // serverSide: false,
                ajaxUrl: "{{ route('admin.app.cards.index') }}"
                , columns: [
                    { data: 'id', searchBuilderType: "num" },
                    { data: 'type', searchBuilderType: 'string' },
                    { data: 'status', searchBuilderType: 'string' },
                    { data: 'view', searchBuilderType: 'string'},
                    { data: 'issue_date', searchBuilderType: 'date' },
                    { data: 'expiry_date', searchBuilderType: 'date' },
                    { data: 'created_at', searchBuilderType: 'date' },
                    { data: 'updated_at', searchBuilderType: 'date' },
                ]
                , defaultOrderColumn: 6
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                }]
                , pageLength: 25
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.app.cards.index') }}"
                , tabToHashMap: {
                    "#service-card-tab": '#service-card'
                    , "#contractor-tab": '#contractor'
                    , "#standardization-tab": '#standardization'
                , }
                , hashToParamsMap: {
                    '#service-card': {
                        type: 'App\\Models\\ServiceCard'
                    }
                    , '#contractor': {
                        type: 'App\\Models\\ContractorRegistration'
                    }
                    , '#standardization': {
                        type: 'App\\Models\\Standardization'
                    }
                , }
                , defaultHash: '#service-card'
            });

            
        });

    </script>
    @endpush
</x-module-layout>
