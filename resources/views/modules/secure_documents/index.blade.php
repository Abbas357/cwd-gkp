<x-document-layout title="Secure Documents">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Secure Documents</li>
    </x-slot>

    <div class="table-responsive">
        <table id="documents-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Document Type</th>
                    <th scope="col" class="p-3">Subject / Title</th>
                    <th scope="col" class="p-3">Description</th>
                    <th scope="col" class="p-3">Number</th>
                    <th scope="col" class="p-3">Officer</th>
                    <th scope="col" class="p-3">Dated</th>
                    <th scope="col" class="p-3">Created At</th>
                    <th scope="col" class="p-3">Updated At</th>
                    <th scope="col" class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <form action=""></form>
    <!--end row-->
    @push('script')
    <script src="{{ asset('admin/plugins/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/col-resizable.js') }}"></script>
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/html2canvas/html2canvas.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = initDataTable('#documents-datatable', {
                ajaxUrl: "{{ route('admin.apps.documents.index') }}"
                , columns: [
                {
                    data: "id"
                    , searchBuilderType: "num"
                }, {
                    data: "document_type"
                    , searchBuilderType: "string"
                }, {
                    data: "title"
                    , searchBuilderType: "string"
                }, {
                    data: "description"
                    , searchBuilderType: "string"
                }, {
                    data: "document_number"
                    , searchBuilderType: "string"
                }, {
                    data: "officer"
                    , searchBuilderType: "string"
                }, {
                    data: "issue_date"
                    , searchBuilderType: "date"
                }, {
                    data: "created_at"
                    , searchBuilderType: "date"
                }, {
                    data: "updated_at"
                    , searchBuilderType: "date"
                }, {
                    data: 'action'
                    , orderable: false
                    , searchable: false
                    , type: "html"
                }]
                , pageLength: 10
                , defaultOrderColumn: 6
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0, 3]
                    , visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ], customButton: {
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; Add Document</span>`
                    , action: function(e, dt, node, config) {

                        formWizardModal({
                            title: 'Add Document',
                            fetchUrl: "{{ route('admin.apps.documents.create') }}",
                            btnSelector: '.create-btn',
                            actionButtonName: 'Add Document',
                            modalSize: 'lg',
                            formAction: "{{ route('admin.apps.documents.store') }}",
                            wizardSteps: [
                                {
                                    title: "Basic Info",
                                    fields: ["#step-1"]
                                },
                                {
                                    title: "Details",
                                    fields: ["#step-2"]
                                },
                            ],
                            formSubmitted() {
                                table.ajax.reload();
                            }
                        });

                    },
                }
            });

            $("#documents-datatable").on('click', '.delete-btn', async function() {
                const documentId = $(this).data("id");
                const url = "{{ route('admin.apps.documents.destroy', ':id') }}".replace(':id', documentId);

                const result = await confirmAction(`Do you want to delete this document?`);
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#documents-datatable").DataTable().ajax.reload();
                    }
                }
            });

            resizableTable('#documents-datatable');

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.documents.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'User Details',
                modalSize: 'lg',
                tableTdoRefresh: table,
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.documents.viewQR', ':id') }}",
                btnSelector: '.qr-btn',
                title: 'QR Code',
                modalSize: 'md',
            });

        });

    </script>
    @endpush
</x-document-layout>
