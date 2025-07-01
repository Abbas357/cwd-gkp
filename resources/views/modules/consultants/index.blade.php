<x-consultant-layout title="Consultant Registrations">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Registrations</li>
    </x-slot>

    <div class="inward-tabs mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="draft-tab" class="nav-link" data-bs-toggle="tab" href="#draft">Draft</a>
            </li>
            <li class="nav-item">
                <a id="approved-tab" class="nav-link" data-bs-toggle="tab" href="#approved">Approved</a>
            </li>
            <li class="nav-item">
                <a id="rejected-tab" class="nav-link" data-bs-toggle="tab" href="#rejected">Rejected</a>
            </li>
        </ul>
    </div>

    <div class="table-responsive">
        <table id="consultants" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Name</th>
                    <th scope="col" class="p-3">Email</th>
                    <th scope="col" class="p-3">Contact Number</th>
                    <th scope="col" class="p-3">District</th>
                    <th scope="col" class="p-3">Address</th>
                    <th scope="col" class="p-3">Sector</th>
                    <th scope="col" class="p-3">PEC Number</th>
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
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = initDataTable('#consultants', {
                ajaxUrl: "{{ route('admin.apps.consultants.index') }}"
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
                        data: "contact_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "district"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "address"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "sector"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "pec_number"
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
                , defaultOrderColumn: 9
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ]
                , pageLength: 25
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.apps.consultants.index') }}"
                , tabToHashMap: {
                    "#draft-tab": '#draft'
                    , "#approved-tab": '#approved'
                    , "#rejected-tab": '#rejected'
                , }
                , hashToParamsMap: {
                    '#draft': {
                        status: 'draft'
                    }
                    , '#approved': {
                        status: 'approved'
                    }
                    , '#rejected': {
                        status: 'rejected'
                    }
                , }
                , defaultHash: '#draft'
            });

            $('#consultants').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.consultants.detail', ':id') }}",
                btnSelector: '.view-btn', 
                title: 'Consultant Details',
                modalSize: 'lg',
                tableToRefresh: table,
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.consultants.hr.detail', ':id') }}",
                btnSelector: '.hr-btn',
                title: 'Consultant Human Resource',
                modalSize: 'xl',
                tableToRefresh: table,
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.consultants.projects.detail', ':id') }}",
                btnSelector: '.projects-btn',
                title: 'Consultant Projects',
                modalSize: 'xl',
                tableToRefresh: table,
            });

        });

    </script>
    @endpush
</x-consultant-layout>
