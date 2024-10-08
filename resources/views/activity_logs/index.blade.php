<x-app-layout title="Activity Log">
    @push('style')
    <link href="{{ asset('plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Activity Log</li>
    </x-slot>

    <table id="log-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Type</th>
                <th scope="col" class="p-3">Record ID</th>
                <th scope="col" class="p-3">Action</th>
                <th scope="col" class="p-3">Field Name</th>
                <th scope="col" class="p-3">Old Value</th>
                <th scope="col" class="p-3">New Value</th>
                <th scope="col" class="p-3">User</th>
                <th scope="col" class="p-3">Date</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <!--end row-->
    @push('script')
    <script src="{{ asset('plugins/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/col-resizable.js') }}"></script>
    <script src="{{ asset('plugins/html2canvas/html2canvas.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = initDataTable('#log-datatable', {
                ajaxUrl: "{{ route('logs') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "loggable_type"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "loggable_id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "action"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "field_name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "old_value"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "new_value"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "user"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "action_at"
                        , searchBuilderType: "date"
                    }
                ]
                , defaultOrderColumn: 8
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                }]
            });
            
        });

    </script>
    @endpush
</x-app-layout>
