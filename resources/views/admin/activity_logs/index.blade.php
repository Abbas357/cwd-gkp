<x-app-layout title="Activity Log">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Activity Log</li>
    </x-slot>

    <div class="table-responsive">
        <table id="log-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Table</th>
                    <th scope="col" class="p-3">Description</th>
                    <th scope="col" class="p-3">Effected Record</th>
                    <th scope="col" class="p-3">Change by</th>
                    <th scope="col" class="p-3">Changed Properties</th>
                    <th scope="col" class="p-3">Date</th>
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
            var table = initDataTable('#log-datatable', {
                // serverSide: false,
                ajaxUrl: "{{ route('admin.activity.index') }}"
                , columns: [
                    { data: 'id', searchBuilderType: "num" },
                    { data: 'log_name', searchBuilderType: 'string' },
                    { data: 'description', searchBuilderType: 'string' },
                    { data: 'subject', searchBuilderType: 'string', orderable: false, searchable: false },
                    { data: 'causer', searchBuilderType: 'string' },
                    { data: 'properties', searchBuilderType: 'string', orderable: false, searchable: false },
                    { data: 'created_at', searchBuilderType: 'date' }
                ]
                , defaultOrderColumn: 6
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                }]
                , pageLength: 25
            });
            
        });

    </script>
    @endpush
</x-app-layout>
