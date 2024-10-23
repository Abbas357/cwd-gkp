<x-app-layout title="Newsletter">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Newsletter</li>
    </x-slot>

    <div class="card-header mb-3 d-flex justify-content-between">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="subscribed-tab" class="nav-link" data-bs-toggle="tab" href="#subscribed">Subscribed</a>
            </li>
            <li class="nav-item">
                <a id="unsubscribed-tab" class="nav-link" data-bs-toggle="tab" href="#unsubscribed">Unsubscribed</a>
            </li>
        </ul>
        <a href="{{ route('admin.newsletter.create_mass_email') }}" class="btn btn-light">Send Mass Email</a>
    </div>

    <table id="newsletter-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Email</th>
                <th scope="col" class="p-3">Subscribed At</th>
                <th scope="col" class="p-3">IP Address</th>
                <th scope="col" class="p-3">Device Info</th>
                <th scope="col" class="p-3">Status</th>
                <th scope="col" class="p-3">Created At</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <!--end row-->
    @push('script')
    <script src="{{ asset('admin/plugins/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/col-resizable.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = initDataTable('#newsletter-datatable', {
                ajaxUrl: "{{ route('admin.newsletter.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "email"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "subscribed_at"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "ip_address"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "device_info"
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
                ]
                , defaultOrderColumn: 11
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                }]
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.newsletter.index') }}"
                , tabToHashMap: {
                    "#subscribed-tab": '#subscribed'
                    , "#unsubscribed-tab": '#unsubscribed'
                , }
                , hashToParamsMap: {
                    '#subscribed': {
                        status: 1
                    }
                    , '#unsubscribed': {
                        status: 0
                    }
                , }
                , defaultHash: '#subscribed'
            });

            $('#newsletter-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

        });

    </script>
    @endpush
</x-app-layout>
