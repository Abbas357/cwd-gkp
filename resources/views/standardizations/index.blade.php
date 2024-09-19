<x-app-layout title="E-Standardization">
    @push('style')
        <link href="{{ asset('plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">E-Standardization</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="new-tab" class="nav-link" data-bs-toggle="tab" href="#new">New</a>
            </li>
            <li class="nav-item">
                <a id="approved-tab" class="nav-link" data-bs-toggle="tab" href="#approved">Approved</a>
            </li>
        </ul>
    </div>

    <table id="standardizations-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Product Name</th>
                <th scope="col" class="p-3">Specification Details</th>
                <th scope="col" class="p-3">Firm Name</th>
                <th scope="col" class="p-3">Address</th>
                <th scope="col" class="p-3">Mobile Number</th>
                <th scope="col" class="p-3">Phone Number</th>
                <th scope="col" class="p-3">Email</th>
                <th scope="col" class="p-3">Locality</th>
                <th scope="col" class="p-3">NTN Number</th>
                <th scope="col" class="p-3">Location Type</th>
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
        <script src="{{ asset('plugins/datatable/js/datatables.min.js') }}"></script>
        <script src="{{ asset('plugins/col-resizable.js') }}"></script>
        
        <script>
            $(document).ready(function() {
                var table = initDataTable('#standardizations-datatable', {
                    ajaxUrl: "{{ route('standardizations.index') }}",
                    columns: [
                        { data: "id", searchBuilderType: "num" },
                        { data: "product_name", searchBuilderType: "string" },
                        { data: "specification_details", searchBuilderType: "string" },
                        { data: "firm_name", searchBuilderType: "string" },
                        { data: "address", searchBuilderType: "string" },
                        { data: "mobile_number", searchBuilderType: "string" },
                        { data: "phone_number", searchBuilderType: "string" },
                        { data: "email", searchBuilderType: "string" },
                        { data: "locality", searchBuilderType: "string" },
                        { data: "ntn_number", searchBuilderType: "string" },
                        { data: "location_type", searchBuilderType: "string" },
                        { data: "created_at", searchBuilderType: "date" },
                        { data: "updated_at", searchBuilderType: "date" },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false,
                            type: "html"
                        }
                    ],
                    defaultOrderColumn: 11,
                    defaultOrderDirection: 'desc',
                    columnDefs: [{
                        targets: [0, 2, 5, 8, 10],
                        visible: false
                    }]
                });

                $("#standardizations-datatable").on('click', '.approve-btn', async function() {
                    const standardizationId = $(this).data("id");
                    const url = "{{ route('standardizations.approve', ':id') }}".replace(':id', standardizationId);

                    const result = await confirmAction('Do you want to approve this registration?');
                    if (result && result.isConfirmed) {
                        const success = await fetchRequest(url, 'PATCH');
                        if (success) {
                            $("#standardizations-datatable").DataTable().ajax.reload();
                        }
                    }
                });

                hashTabsNavigator({
                    table: table,
                    dataTableUrl: "{{ route('standardizations.index') }}",
                    tabToHashMap: {
                        "#new-tab": '#new',
                        "#approved-tab": '#approved',
                    },
                    hashToParamsMap: {
                        '#new': { approved: 0 },
                        '#approved': { approved: 1 },
                    },   
                    defaultHash: '#new'
                });
            
                $('#standardizations-datatable').colResizable(
                { 
                    liveDrag: true,
                    resizeMode:'overflow',
                    postbackSafe:true,
                    useLocalStorage: true,
                    gripInnerHtml: "<div class='grip'></div>",
                    draggingClass:"dragging",
                });
            });
                
        </script>
    @endpush
</x-app-layout>
