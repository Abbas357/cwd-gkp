<x-contractor-layout title="Contractor Registrations">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
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
                <a id="deferred-once-tab" class="nav-link" data-bs-toggle="tab" href="#deferred_once">Deferred once</a>
            </li>
            <li class="nav-item">
                <a id="deferred-twice-tab" class="nav-link" data-bs-toggle="tab" href="#deferred_twice">Deferred twice</a>
            </li>
            <li class="nav-item">
                <a id="deferred-thrice-tab" class="nav-link" data-bs-toggle="tab" href="#deferred_thrice">Deferred thrice</a>
            </li>
            <li class="nav-item">
                <a id="approved-tab" class="nav-link" data-bs-toggle="tab" href="#approved">Approved</a>
            </li>
        </ul>
    </div>

    <div class="table-responsive">
        <table id="contractors-registration" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Name</th>
                    <th scope="col" class="p-3">Firm Name</th>
                    <th scope="col" class="p-3">Email</th>
                    <th scope="col" class="p-3">Mobile Number</th>
                    <th scope="col" class="p-3">CNIC</th>
                    <th scope="col" class="p-3">District</th>
                    <th scope="col" class="p-3">Address</th>
                    <th scope="col" class="p-3">PEC Number</th>
                    <th scope="col" class="p-3">PEC Category</th>
                    <th scope="col" class="p-3">FBR NTN</th>
                    <th scope="col" class="p-3">KPRA Registration</th>
                    <th scope="col" class="p-3">Registration Limited</th>
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

    <script>
        $(document).ready(function() {
            var table = initDataTable('#contractors-registration', {
                ajaxUrl: "{{ route('admin.apps.contractors.registration.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }, {
                        data: "name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "firm_name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "email"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "mobile_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "cnic"
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
                        data: "pec_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "pec_category"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "fbr_ntn"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "kpra_reg_no"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "is_limited"
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
                , defaultOrderColumn: 14
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0, 2, 3, 6, 11, 12, 13, 14]
                    , visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ]
                , pageLength: 10
            });

            $("#contractors-registration").on('click', '.defer-btn', async function() {
                const registrationId = $(this).data("id");
                const url = "{{ route('admin.apps.contractors.registration.defer', ':id') }}".replace(':id', registrationId);

                const { value: remarks } = await confirmWithInput({
                    inputType: "textarea",
                    text: 'Do you want to deffered this registration?'
                    , inputValidator: (value) => {
                        if (!value) {
                            return 'You need to provide reason / remarks!';
                        }
                    }
                    , inputPlaceholder: 'Enter the reason for deffering'
                    , confirmButtonText: 'Reject'
                    , cancelButtonText: 'Cancel'
                });

                if (remarks) {
                    const success = await fetchRequest(url, 'PATCH', {
                        remarks
                    });
                    if (success) {
                        $("#contractors-registration").DataTable().ajax.reload();
                    }
                }
            });

            $("#contractors-registration").on('click', '.renew-btn', async function() {
                const registrationId = $(this).data("id");
                const url = "{{ route('admin.apps.contractors.registration.renew', ':id') }}".replace(':id', registrationId);

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
                        $("#contractors-registration").DataTable().ajax.reload();
                    }
                }
            });

            $("#contractors-registration").on('click', '.approve-btn', async function() {
                const registrationId = $(this).data("id");
                const url = "{{ route('admin.apps.contractors.registration.approve', ':id') }}".replace(':id', registrationId);

                const result = await confirmAction('Do you want to approve this registration?');
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#contractors-registration").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.apps.contractors.registration.index') }}"
                , tabToHashMap: {
                    "#draft-tab": '#draft'
                    , "#deferred-once-tab": '#deferred_once'
                    , "#deferred-twice-tab": '#deferred_twice'
                    , "#deferred-thrice-tab": '#deferred_thrice'
                    , "#approved-tab": '#approved'
                , }
                , hashToParamsMap: {
                    '#draft': {
                        status: 'draft'
                    }
                    , '#deferred_once': {
                        status: 'deferred_once'
                    }
                    , '#deferred_twice': {
                        status: 'deferred_twice'
                    }
                    , '#deferred_thrice': {
                        status: 'deferred_thrice'
                    }
                    , '#approved': {
                        status: 'approved'
                    }
                , }
                , defaultHash: '#draft'
            });

            $('#contractors-registration').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.contractors.registration.showDetail', ':id') }}"
                , btnSelector: '.view-btn'
                , title: 'Registrations Details'
                , modalSize: 'lg'
                , tableToRefresh: table
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.contractors.registration.showCard', ':id') }}"
                , btnSelector: '.card-btn'
                , title: 'Contractor Card'
                , modalSize: 'md'
                , actionButtonName: 'Download Card'
            , }).then((modal) => {
                const actionBtn = $('#'+modal).find('button[type="submit"]');
                actionBtn.on('click', function() {
                    var div = $('#capture')[0];
                    html2canvas(div, {
                        scale: 2,
                        useCORS: true
                    }).then(function(canvas) {
                        canvas.toBlob(function(blob) {
                            var link = $('<a></a>')[0];
                            link.href = URL.createObjectURL(blob);
                            link.download = `contractor-card-${uniqId(6)}.png`;
                            link.click();
                        });
                    });
                })
            });
        });

    </script>
    @endpush
</x-contractor-layout>
