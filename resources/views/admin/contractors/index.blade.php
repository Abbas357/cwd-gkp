<x-app-layout title="Contractor Registrations">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Registrations</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="active-tab" class="nav-link" data-bs-toggle="tab" href="#active">Active</a>
            </li>
            <li class="nav-item">
                <a id="blacklisted-tab" class="nav-link" data-bs-toggle="tab" href="#blacklisted">Blacklisted</a>
            </li>
            <li class="nav-item">
                <a id="suspended-tab" class="nav-link" data-bs-toggle="tab" href="#suspended">Suspended</a>
            </li>
            <li class="nav-item">
                <a id="dormant-tab" class="nav-link" data-bs-toggle="tab" href="#dormant">Dormant</a>
            </li>
        </ul>
    </div>

    <table id="contractors" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Name</th>
                <th scope="col" class="p-3">Email</th>
                <th scope="col" class="p-3">CNIC</th>
                <th scope="col" class="p-3">Mobile Number</th>
                <th scope="col" class="p-3">District</th>
                <th scope="col" class="p-3">Firm Name</th>
                <th scope="col" class="p-3">Address</th>
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
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = initDataTable('#contractors', {
                ajaxUrl: "{{ route('admin.contractors.index') }}"
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
                        data: "cnic"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "mobile_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "district"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "firm_name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "address"
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
                    targets: [0, 7]
                    , visible: false
                }]
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.contractors.index') }}"
                , tabToHashMap: {
                    "#active-tab": '#active'
                    , "#blacklisted-tab": '#blacklisted'
                    , "#suspended-tab": '#suspended'
                    , "#dormant-tab": '#dormant'
                , }
                , hashToParamsMap: {
                    '#active': {
                        status: 'active'
                    }
                    , '#blacklisted': {
                        status: 'blacklisted'
                    }
                    , '#suspended': {
                        status: 'suspended'
                    }
                    , '#dormant': {
                        status: 'dormant'
                    }
                , }
                , defaultHash: '#active'
            });

            $('#contractors').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.contractors.detail', ':id') }}"
                , btnSelector: '.view-btn'
                , title: 'Contractor Details'
                , modalSize: 'lg'
                , 
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.contractors.hr.detail', ':id') }}"
                , btnSelector: '.hr-btn'
                , title: 'Contractor Human Resource'
                , modalSize: 'xl'
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.contractors.machinery.detail', ':id') }}"
                , btnSelector: '.machinery-btn'
                , title: 'Contractor Machinery'
                , modalSize: 'xl'
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.contractors.experience.detail', ':id') }}"
                , btnSelector: '.experience-btn'
                , title: 'Contractor Work Experience'
                , modalSize: 'xl'
            });

        });

    </script>
    @endpush
</x-app-layout>
