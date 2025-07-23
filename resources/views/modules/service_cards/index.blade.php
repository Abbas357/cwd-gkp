<x-service-card-layout title="Service Card">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Service Card</li>
    </x-slot>

    <div class="inward-tabs mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="draft-tab" class="nav-link" data-bs-toggle="tab" href="#draft">Draft</a>
            </li>
            <li class="nav-item">
                <a id="verified-tab" class="nav-link" data-bs-toggle="tab" href="#verified">Verified</a>
            </li>
            <li class="nav-item">
                <a id="rejected-tab" class="nav-link" data-bs-toggle="tab" href="#rejected">Rejected</a>
            </li>
            <li class="nav-item">
                <a id="active-tab" class="nav-link" data-bs-toggle="tab" href="#active">Active Cards</a>
            </li>
            <li class="nav-item">
                <a id="expired-tab" class="nav-link" data-bs-toggle="tab" href="#expired">Expired Cards</a>
            </li>
        </ul>
    </div>

    <div class="table-responsive">
        <table id="service-card-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col" class="p-3">ID</th>
                    <th scope="col" class="p-3">Name</th>
                    <th scope="col" class="p-3">CNIC</th>
                    <th scope="col" class="p-3">Email</th>
                    <th scope="col" class="p-3">Mobile Number</th>
                    <th scope="col" class="p-3">Designation</th>
                    <th scope="col" class="p-3">Office</th>
                    <th scope="col" class="p-3">Approval Status</th>
                    <th scope="col" class="p-3">Card Status</th>
                    <th scope="col" class="p-3">Card Validity</th>
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
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/html2canvas/html2canvas.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = initDataTable('#service-card-datatable', {
                ajaxUrl: "{{ route('admin.apps.service_cards.index') }}"
                , columns: [
                {
                    data: "id"
                    , searchBuilderType: "num"
                }, {
                    data: "name"
                    , searchBuilderType: "string"
                }, {
                    data: "cnic"
                    , searchBuilderType: "string"
                }, {
                    data: "email"
                    , searchBuilderType: "string"
                }, {
                    data: "mobile_number"
                    , searchBuilderType: "string"
                }, {
                    data: "designation"
                    , searchBuilderType: "string"
                }, {
                    data: "office"
                    , searchBuilderType: "string"
                }, {
                    data: "approval_status"
                    , searchBuilderType: "string"
                }, {
                    data: "card_status"
                    , searchBuilderType: "string"
                }, {
                    data: "card_validity"
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
                , pageLength: 25
                , defaultOrderColumn: 11
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0, 2, 8]
                    , visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ], customButtons: [
                    {
                        text: `<span class="symbol-container cw-btn bg-primary text-light"><i class="bi-plus-circle"></i>Create Card</span>`
                        , action: function(e, dt, node, config) {
                            window.location.href = "{{ route('admin.apps.service_cards.create') }}";
                        },
                    },
                ]
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.apps.service_cards.index') }}"
                , tabToHashMap: {
                    "#draft-tab": '#draft'
                    , "#verified-tab": '#verified'
                    , "#rejected-tab": '#rejected'
                    , "#active-tab": '#active'
                    , "#expired-tab": '#expired'
                , }
                , hashToParamsMap: {
                    '#draft': {
                        approval_status: 'draft'
                    }
                    , '#verified': {
                        approval_status: 'verified'
                    }
                    , '#rejected': {
                        approval_status: 'rejected'
                    }
                    , '#active': {
                        card_status: 'active',
                        approval_status: 'verified'
                    }
                    , '#expired': {
                        card_status: 'expired'
                    }
                , }
                , defaultHash: '#draft'
            });

            $("#service-card-datatable").on('click', '.verify-btn', async function() {
                const cardId = $(this).data("id");
                const url = "{{ route('admin.apps.service_cards.verify', ':id') }}".replace(':id', cardId);

                const result = await confirmAction('Do you want to Verify this service card?');
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#service-card-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#service-card-datatable").on('click', '.reject-btn', async function() {
                const cardId = $(this).data("id");
                const url = "{{ route('admin.apps.service_cards.reject', ':id') }}".replace(':id', cardId);

                const {
                    value: reason
                } = await confirmWithInput({
                    inputType: "textarea"
                    , text: 'Do you want to reject this service card?'
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
                        $("#service-card-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#service-card-datatable").on('click', '.renew-btn', async function() {
                const cardId = $(this).data("id");
                const url = "{{ route('admin.apps.service_cards.renew', ':id') }}".replace(':id', cardId);

                const result = await confirmAction('Do you want to renew this service card? This will create a new card with a 1-year validity.');
                if (result && result.isConfirmed) {
                    const response = await fetchRequest(url, 'PATCH');
                    if (response && response.new_card_id) {
                        await Swal.fire({
                            icon: 'success',
                            title: 'Card Renewed',
                            text: 'Service card has been renewed successfully. A new card has been created.',
                            confirmButtonText: 'View New Card'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Optionally redirect to the new card or show it
                                window.location.href = "{{ route('admin.apps.service_cards.show', ':id') }}".replace(':id', response.new_card_id);
                            }
                        });
                        $("#service-card-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#service-card-datatable").on('click', '.restore-btn', async function() {
                const cardId = $(this).data("id");
                const url = "{{ route('admin.apps.service_cards.restore', ':id') }}".replace(':id', cardId);

                const result = await confirmAction('Would you like to restore this service card to draft status?');
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#service-card-datatable").DataTable().ajax.reload();
                    }
                }
            });

            // Additional card status actions
            $("#service-card-datatable").on('click', '.revoke-btn', async function() {
                const cardId = $(this).data("id");
                const url = "{{ route('admin.apps.service_cards.updateStatus', ':id') }}".replace(':id', cardId);

                const {
                    value: reason
                } = await confirmWithInput({
                    inputType: "textarea"
                    , text: 'Do you want to revoke this service card?'
                    , inputValidator: (value) => {
                        if (!value) {
                            return 'You need to provide a reason!';
                        }
                    }
                    , inputPlaceholder: 'Enter the reason for revocation'
                    , confirmButtonText: 'Revoke'
                    , cancelButtonText: 'Cancel'
                });

                if (reason) {
                    const success = await fetchRequest(url, 'PATCH', {
                        card_status: 'revoked',
                        remarks: reason
                    });
                    if (success) {
                        $("#service-card-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#service-card-datatable").on('click', '.mark-lost-btn', async function() {
                const cardId = $(this).data("id");
                const url = "{{ route('admin.apps.service_cards.updateStatus', ':id') }}".replace(':id', cardId);

                const result = await confirmAction('Do you want to mark this service card as lost?');
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH', {
                        card_status: 'lost'
                    });
                    if (success) {
                        $("#service-card-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#service-card-datatable").on('click', '.revoke-btn', async function() {
                const cardId = $(this).data("id");
                const url = "{{ route('admin.apps.service_cards.revoke', ':id') }}".replace(':id', cardId);

                const {
                    value: reason
                } = await confirmWithInput({
                    inputType: "textarea",
                    text: 'Why are you revoking this service card?',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'You need to provide a reason!';
                        }
                    },
                    inputPlaceholder: 'Enter the reason for revocation',
                    confirmButtonText: 'Revoke',
                    cancelButtonText: 'Cancel'
                });

                if (reason) {
                    const success = await fetchRequest(url, 'PATCH', { reason });
                    if (success) {
                        $("#service-card-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#service-card-datatable").on('click', '.mark-lost-btn', async function() {
                const cardId = $(this).data("id");
                const url = "{{ route('admin.apps.service_cards.markLost', ':id') }}".replace(':id', cardId);

                const result = await confirmAction('Mark this service card as lost?');
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#service-card-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#service-card-datatable").on('click', '.reprint-btn', async function() {
                const cardId = $(this).data("id");
                const url = "{{ route('admin.apps.service_cards.reprint', ':id') }}".replace(':id', cardId);

                const result = await confirmAction('Create a replacement card for this lost card?');
                if (result && result.isConfirmed) {
                    const response = await fetchRequest(url, 'PATCH');
                    if (response && response.new_card_id) {
                        await Swal.fire({
                            icon: 'success',
                            title: 'Card Reprinted',
                            text: 'A replacement card has been created.',
                            confirmButtonText: 'View New Card'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('admin.apps.service_cards.show', ':id') }}".replace(':id', response.new_card_id);
                            }
                        });
                        $("#service-card-datatable").DataTable().ajax.reload();
                    }
                }
            });

            resizableTable('#service-card-datatable');

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.service_cards.detail', ':id') }}",
                btnSelector: '.view-btn',
                title: 'Service Card Details',
                modalSize: 'lg',
                tableToRefresh: table
             });

            pushStateModal({
                fetchUrl: "{{ route('admin.apps.service_cards.showCard', ':id') }}"
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
</x-service-card-layout>