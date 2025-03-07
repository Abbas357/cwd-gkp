<x-porms-layout title="Provincial Own Recepts">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Provincial Own Recepts</li>
    </x-slot>

    <div class="table-responsive">
        <table id="porms-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Month</th>
                    <th>DDO Code</th>
                    <th>District</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
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
            var table = initDataTable('#porms-datatable', {
                ajaxUrl: "{{ route('admin.apps.porms.all') }}"
                , columns: [
                    {
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "month"
                        , searchBuilderType: "date"
                    },
                    {
                        data: 'ddo_code',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'district',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'type',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'amount',
                        searchBuilderType: "string"
                    },
                    {
                        data: 'created_at',
                        searchBuilderType: "date"
                    },
                    {
                        data: 'updated_at',
                        searchBuilderType: "date"
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
                , defaultOrderColumn: 7
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0]
                    , visible: false
                }]
                , pageLength: 25
                , customButton: {
                    text: `<span class="symbol-container fw-bold create-btn"><i class="bi-plus-circle"></i>&nbsp; Add Receipt</span>`
                    , action: function(e, dt, node, config) {

                       formWizardModal({
                            title: 'Add Receipt',
                            fetchUrl: "{{ route('admin.apps.porms.create') }}",
                            btnSelector: '.create-btn',
                            actionButtonName: 'Add Receipt',
                            modalSize: 'lg',
                            formAction: "{{ route('admin.apps.porms.store') }}",
                            wizardSteps: [
                                {
                                    title: "Basic Info",
                                    fields: ["#step-1"]
                                },
                                {
                                    title: "Receipt Details",
                                    fields: ["#step-2"]
                                },
                                {
                                    title: "Remarks",
                                    fields: ["#step-3"]
                                }
                            ],
                            formSubmitted() {
                                window.location.reload();
                            }
                        });

                    },
                }
            });

            $("#porms-datatable").on('click', '.delete-btn', async function() {
                const receiptId = $(this).data("id");
                const url = "{{ route('admin.apps.porms.destroy', ':id') }}".replace(':id', receiptId);

                const result = await confirmAction(`Do you want to delete this receipt?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#porms-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $('#porms-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.porms.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Receipt Details',
                modalSize: 'lg',
            });

            
        });

    </script>
    @endpush
</x-porms-layout>
