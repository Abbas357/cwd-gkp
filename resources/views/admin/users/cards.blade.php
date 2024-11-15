<x-app-layout title="Identity Cards">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Identity Cards</li>
    </x-slot>

    <div class="card-header mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="new-tab" class="nav-link" data-bs-toggle="tab" href="#new">New</a>
            </li>
            <li class="nav-item">
                <a id="verified-tab" class="nav-link" data-bs-toggle="tab" href="#verified">Verified</a>
            </li>
            <li class="nav-item">
                <a id="rejected-tab" class="nav-link" data-bs-toggle="tab" href="#rejected">Rejected</a>
            </li>
        </ul>
    </div>

    <table id="cards-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Name</th>
                <th scope="col" class="p-3">Father Name</th>
                <th scope="col" class="p-3">Date of Birth</th>
                <th scope="col" class="p-3">CNIC</th>
                <th scope="col" class="p-3">Email</th>
                <th scope="col" class="p-3">Personnel Number</th>
                <th scope="col" class="p-3">Mobile Number</th>
                <th scope="col" class="p-3">Landline Number</th>
                <th scope="col" class="p-3">Designation</th>
                <th scope="col" class="p-3">Position</th>
                <th scope="col" class="p-3">BPS</th>
                <th scope="col" class="p-3">Office</th>
                <th scope="col" class="p-3">Mark Of Identification</th>
                <th scope="col" class="p-3">Blood Group</th>
                <th scope="col" class="p-3">Emergency Contact</th>
                <th scope="col" class="p-3">Parmanent Address</th>
                <th scope="col" class="p-3">Present Address</th>
                <th scope="col" class="p-3">Created At</th>
                <th scope="col" class="p-3">Updated At</th>
                <th scope="col" class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
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
            var table = initDataTable('#cards-datatable', {
                ajaxUrl: "{{ route('admin.users.cards') }}"
                , columns: [{
                    data: "id"
                    , searchBuilderType: "num"
                }, {
                    data: "name"
                    , searchBuilderType: "string"
                }, {
                    data: "father_name"
                    , searchBuilderType: "string"
                }, {
                    data: "date_of_birth"
                    , searchBuilderType: "string"
                }, {
                    data: "cnic"
                    , searchBuilderType: "string"
                }, {
                    data: "email"
                    , searchBuilderType: "string"
                }, {
                    data: "personnel_number"
                    , searchBuilderType: "string"
                }, {
                    data: "mobile_number"
                    , searchBuilderType: "string"
                }, {
                    data: "landline_number"
                    , searchBuilderType: "date"
                }, {
                    data: "designation"
                    , searchBuilderType: "string"
                }, {
                    data: "position"
                    , searchBuilderType: "string"
                }, {
                    data: "bps"
                    , searchBuilderType: "string"
                }, {
                    data: "office"
                    , searchBuilderType: "string"
                }, {
                    data: "mark_of_identification"
                    , searchBuilderType: "string"
                }, {
                    data: "blood_group"
                    , searchBuilderType: "string"
                }, {
                    data: "emergency_contact"
                    , searchBuilderType: "string"
                }, {
                    data: "parmanent_address"
                    , searchBuilderType: "string"
                }, {
                    data: "present_address"
                    , searchBuilderType: "string"
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
                , defaultOrderColumn: 11
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0, 2, 3, 5, 6, 8, 11, 12, 14, 15]
                    , visible: false
                }]
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.users.cards') }}"
                , tabToHashMap: {
                    "#new-tab": '#new'
                    , "#verified-tab": '#verified'
                    , "#rejected-tab": '#rejected'
                , }
                , hashToParamsMap: {
                    '#new': {
                        status: 'new'
                    }
                    , '#verified': {
                        status: 'verified'
                    }
                    , '#rejected': {
                        status: 'rejected'
                    }
                , }
                , defaultHash: '#new'
            });

            $("#cards-datatable").on('click', '.verify-btn', async function() {
                const userId = $(this).data("id");
                const url = "{{ route('admin.users.verify', ':id') }}".replace(':id', userId);

                const result = await confirmAction('Do you want to Verify this user?');
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#cards-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#cards-datatable").on('click', '.reject-btn', async function() {
                const userId = $(this).data("id");
                const url = "{{ route('admin.users.reject', ':id') }}".replace(':id', userId);

                const {
                    value: reason
                } = await confirmWithInput({
                    inputType: "textarea"
                    , text: 'Do you want to reject this user?'
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
                        $("#cards-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#cards-datatable").on('click', '.renew-btn', async function() {
                const userId = $(this).data("id");
                const url = "{{ route('admin.users.renew', ':id') }}".replace(':id', userId);

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
                        $("#cards-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#cards-datatable").on('click', '.restore-btn', async function() {
                const userId = $(this).data("id");
                const url = "{{ route('admin.users.restore', ':id') }}".replace(':id', userId);

                const result = await confirmAction('Would you like to reconsider this user\'s status?');
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#cards-datatable").DataTable().ajax.reload();
                    }
                }
            });

            resizableTable('#cards-datatable');

            pushStateModal({
                fetchUrl: "{{ route('admin.users.detail', ':id') }}"
                , btnSelector: '.view-btn'
                , title: 'User Details'
                , modalSize: 'lg'
            , });

            pushStateModal({
                fetchUrl: "{{ route('admin.users.showCard', ':id') }}"
                , btnSelector: '.card-btn'
                , title: 'Service Card'
                , modalSize: 'md'
                , actionButtonName: 'Download Card'
            , }).then((modal) => {
                const actionBtn = $('#' + modal).find('button[type="submit"]');
                actionBtn.on('click', function() {
                    var div = $('#capture')[0];
                    html2canvas(div, {
                        scale: 3
                        , useCORS: true
                        , logging: false
                    }).then(function(canvas) {
                        canvas.toBlob(function(blob) {
                            var link = $('<a></a>')[0];
                            link.href = URL.createObjectURL(blob);
                            link.download = `service-card-${uniqId(6)}.png`;
                            link.click();
                        });
                    });
                })
            });

        });

    </script>
    @endpush
</x-app-layout>
