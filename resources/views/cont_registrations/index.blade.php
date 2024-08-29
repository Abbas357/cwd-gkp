<x-app-layout>
    @push('style')
        <link href="{{ asset('plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Contractor Registrations</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a id="tab-defer0" class="nav-link active" data-bs-toggle="tab" href="#not-deferred">Not Deferred</a>
            </li>
            <li class="nav-item">
                <a id="tab-defer1" class="nav-link" data-bs-toggle="tab" href="#deferred1">Deferred 1</a>
            </li>
            <li class="nav-item">
                <a id="tab-defer2" class="nav-link" data-bs-toggle="tab" href="#deferred2">Deferred 2</a>
            </li>
            <li class="nav-item">
                <a id="tab-defer3" class="nav-link" data-bs-toggle="tab" href="#deferred3">Deferred 3</a>
            </li>
            <li class="nav-item">
                <a id="tab-approved" class="nav-link" data-bs-toggle="tab" href="#approved">Approved</a>
            </li>
        </ul>
    </div>

    <table id="registrations-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Contractor Name</th>
                <th scope="col" class="p-3">Email</th>
                <th scope="col" class="p-3">Mobile Number</th>
                <th scope="col" class="p-3">CNIC</th>
                <th scope="col" class="p-3">District</th>
                <th scope="col" class="p-3">Address</th>
                <th scope="col" class="p-3">Category Applied</th>
                <th scope="col" class="p-3">Owner Name</th>
                <th scope="col" class="p-3">PEC Number</th>
                <th scope="col" class="p-3">PEC Category</th>
                <th scope="col" class="p-3">FBR NTN</th>
                <th scope="col" class="p-3">KPRA Registration</th>
                <th scope="col" class="p-3">Registration Limited</th>
                <th scope="col" class="p-3">Terms Accepted</th>
                <th scope="col" class="p-3">Defer Status</th>
                <th scope="col" class="p-3">Approval Status</th>
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
                var table = initDataTable('#registrations-datatable', {
                    ajaxUrl: "{{ route('registrations.index') }}",
                    columns: [
                        { data: "id", searchBuilderType: "num" },
                        { data: "contractor_name", searchBuilderType: "string" },
                        { data: "email", searchBuilderType: "string" },
                        { data: "mobile_number", searchBuilderType: "string" },
                        { data: "cnic", searchBuilderType: "string" },
                        { data: "district", searchBuilderType: "string" },
                        { data: "address", searchBuilderType: "string" },
                        { data: "category_applied", searchBuilderType: "string" },
                        { data: "owner_name", searchBuilderType: "string" },
                        { data: "pec_number", searchBuilderType: "string" },
                        { data: "pec_category", searchBuilderType: "string" },
                        { data: "fbr_ntn", searchBuilderType: "string" },
                        { data: "kpra_reg_no", searchBuilderType: "string" },
                        { data: "is_limited", searchBuilderType: "string" },
                        { data: "is_agreed", searchBuilderType: "string" },
                        { data: "defer_status", searchBuilderType: "string" },
                        { data: "approval_status", searchBuilderType: "string" },
                        { data: "created_at", searchBuilderType: "date" },
                        { data: "updated_at", searchBuilderType: "date" },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false,
                            type: "html"
                        }
                    ],
                    defaultOrderColumn: 17,
                    defaultOrderDirection: 'desc',
                    columnDefs: [{
                        targets: [0, 2, 3, 6, 11, 12, 13, 14, 15, 16],
                        visible: false
                    }]
                });

                $("#registrations-datatable").on('click', '.defer-btn', async function() {
                    const registrationId = $(this).data("id");
                    const url = "{{ route('registrations.defer', ':id') }}".replace(':id', registrationId);

                    const result = await confirmAction('Do you want to defer this registration?');
                    if (result && result.isConfirmed) {
                        const success = await fetchRequest(url, 'PATCH');
                        if (success) {
                            $("#registrations-datatable").DataTable().ajax.reload();
                        }
                    }
                });

                $("#registrations-datatable").on('click', '.approve-btn', async function() {
                    const registrationId = $(this).data("id");
                    const url = "{{ route('registrations.approve', ':id') }}".replace(':id', registrationId);

                    const result = await confirmAction('Do you want to approve this registration?');
                    if (result && result.isConfirmed) {
                        const success = await fetchRequest(url, 'PATCH');
                        if (success) {
                            $("#registrations-datatable").DataTable().ajax.reload();
                        }
                    }
                });

                tabHashNavigation({
                    table: table,
                    dataTableUrl: "{{ route('registrations.index') }}",
                    tabToHashMap: {
                        "#tab-defer0": '#not-deferred',
                        "#tab-defer1": '#deferred1',
                        "#tab-defer2": '#deferred2',
                        "#tab-defer3": '#deferred3',
                        "#tab-approved": '#approved',
                    },
                    hashToParamsMap: {
                        '#not-deferred': { defer: 0 },
                        '#deferred1': { defer: 1 },
                        '#deferred2': { defer: 2 },
                        '#deferred3': { defer: 3 },
                        '#approved': { approved: 1 },
                    },   
                    defaultHash: '#not-deferred'
                });
            
                $('#registrations-datatable').colResizable(
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
