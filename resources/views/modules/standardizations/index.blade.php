<x-standardization-layout title="E-Standardization">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">E-Standardization</li>
    </x-slot>

    <div class="card-header mb-3">
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
            <li class="nav-item">
                <a id="blacklisted-tab" class="nav-link" data-bs-toggle="tab" href="#blacklisted">Blacklisted</a>
            </li>
        </ul>
    </div>

    <div class="table-responsive">
        <table id="standardizations" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Firm Name</th>
                    <th scope="col" class="p-3">Address</th>
                    <th scope="col" class="p-3">Mobile Number</th>
                    <th scope="col" class="p-3">Email</th>
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
            var table = initDataTable('#standardizations', {
                ajaxUrl: "{{ route('admin.apps.standardizations.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
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
                        data: "mobile_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "email"
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
                , pageLength: 25
                , defaultOrderColumn: 5
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0, 2, 5]
                    , visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ]
            });

            $("#standardizations").on('click', '.approve-btn', async function() {
                const standardizationId = $(this).data("id");
                const url = "{{ route('admin.apps.standardizations.approve', ':id') }}".replace(':id', standardizationId);

                const result = await confirmAction('Do you want to approve this firm?');
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#standardizations").DataTable().ajax.reload();
                    }
                }
            });

            $("#standardizations").on('click', '.renew-btn', async function() {
                const standardizationId = $(this).data("id");
                const url = "{{ route('admin.apps.standardizations.renew', ':id') }}".replace(':id', standardizationId);

                const {
                    value: issue_date
                } = await confirmWithInput({
                    inputType: "date"
                    , text: 'Renew! (Issue Date is Optional)'
                    , inputValidator: (value) => {}
                    , inputPlaceholder: 'Enter the issue date (optional)'
                    , confirmButtonText: 'Renew'
                    , cancelButtonText: 'Cancel'
                });

                if (issue_date === '' || issue_date) {
                    const success = await fetchRequest(url, 'PATCH', {
                        issue_date
                    });
                    if (success) {
                        $("#standardizations").DataTable().ajax.reload();
                    }
                }
            });

            $("#standardizations").on('click', '.reject-btn', async function() {
                const standardizationId = $(this).data("id");
                const url = "{{ route('admin.apps.standardizations.reject', ':id') }}".replace(':id', standardizationId);

                const {
                    value: remarks
                } = await confirmWithInput({
                    inputType: "textarea",
                    text: 'Do you want to reject this firm?'
                    , inputValidator: (value) => {
                        if (!value) {
                            return 'You need to provide a reason!';
                        }
                    }
                    , inputPlaceholder: 'Enter the reason for rejection'
                    , confirmButtonText: 'Reject'
                    , cancelButtonText: 'Cancel'
                });

                if (reason) {
                    const success = await fetchRequest(url, 'PATCH', {
                        reason
                    });
                    if (success) {
                        $("#standardizations").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.apps.standardizations.index') }}"
                , tabToHashMap: {
                    "#draft-tab": '#draft'
                    , "#approved-tab": '#approved'
                    , "#rejected-tab": '#rejected'
                    , "#blacklisted-tab": '#blacklisted'
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
                    , '#blacklisted': {
                        status: 'blacklisted'
                    }
                , }
                , defaultHash: '#draft'
            });

            $('#standardizations').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.standardizations.card', ':id') }}",
                btnSelector: '.card-btn',
                title: 'Standardization Card',
                actionButtonName: 'Download Card',
            }).then((modal) => {
                const actionBtn = $('#'+modal).find('button[type="submit"]');
                actionBtn.on('click', function() {
                    var div = $('#capture')[0];
                    html2canvas(div, {
                        scale: 2
                    }).then(function(canvas) {
                        canvas.toBlob(function(blob) {
                            var link = $('<a></a>')[0];
                            link.href = URL.createObjectURL(blob);
                            link.download = `card-${uniqId(6)}.png`;
                            link.click();
                        });
                    });
                })
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.standardizations.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Standardization Details',
                modalSize: 'lg',
            });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.standardizations.product.detail', ':id') }}"
                , btnSelector: '.product-btn'
                , title: 'Products'
                , modalSize: 'xl'
            });
            
        });

    </script>
    @endpush
</x-standardization-layout>
