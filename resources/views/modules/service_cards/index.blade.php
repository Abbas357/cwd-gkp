<x-service-card-layout title="Service Card">
    @push('style')
        <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">

        <style>
            #draft-tab .tab-counter {
                background-color: #6c757d !important;
            }

            #verified-tab .tab-counter {
                background-color: #28a745 !important;
            }

            #rejected-tab .tab-counter {
                background-color: #dc3545 !important;
            }

            #printed-tab .tab-counter {
                background-color: #007bff !important;
            }

            #expired-tab .tab-counter {
                background-color: #ffc107 !important;
                color: #000;
            }

            #needs-renewal-tab .tab-counter {
                background-color: #fd7e14 !important;
            }

            #lost-tab .tab-counter {
                background-color: #343a40 !important;
            }

            #duplicate-tab .tab-counter {
                background-color: #17a2b8 !important;
            }
        </style>
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Service Card</li>
    </x-slot>

    <div class="tabs-wrapper">
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
                    <a id="printed-tab" class="nav-link" data-bs-toggle="tab" href="#printed">Printed</a>
                </li>
                <li class="nav-item">
                    <a id="expired-tab" class="nav-link" data-bs-toggle="tab" href="#expired">Expired</a>
                </li>
                <li class="nav-item">
                    <a id="needs-renewal-tab" class="nav-link" data-bs-toggle="tab" href="#needs-renewal">Needs
                        Renewal</a>
                </li>
                <li class="nav-item">
                    <a id="lost-tab" class="nav-link" data-bs-toggle="tab" href="#lost">Lost</a>
                </li>
                <li class="nav-item">
                    <a id="duplicate-tab" class="nav-link" data-bs-toggle="tab" href="#duplicate">Duplicate</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-responsive">
        <table id="service-card-datatable" width="100%"
            class="table table-striped table-hover table-bordered align-center">
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
        <script src="{{ asset('admin/plugins/jspdf/jspdf.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                var table = initDataTable('#service-card-datatable', {
                    ajaxUrl: "{{ route('admin.apps.service_cards.index') }}",
                    columns: [{
                        data: "id",
                        searchBuilderType: "num"
                    }, {
                        data: "name",
                        searchBuilderType: "string"
                    }, {
                        data: "cnic",
                        searchBuilderType: "string"
                    }, {
                        data: "email",
                        searchBuilderType: "string"
                    }, {
                        data: "mobile_number",
                        searchBuilderType: "string"
                    }, {
                        data: "designation",
                        searchBuilderType: "string"
                    }, {
                        data: "office",
                        searchBuilderType: "string"
                    }, {
                        data: "approval_status",
                        searchBuilderType: "string"
                    }, {
                        data: "card_status",
                        searchBuilderType: "string"
                    }, {
                        data: "card_validity",
                        searchBuilderType: "string"
                    }, {
                        data: "created_at",
                        searchBuilderType: "date"
                    }, {
                        data: "updated_at",
                        searchBuilderType: "date"
                    }, {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        type: "html"
                    }],
                    pageLength: 25,
                    defaultOrderColumn: 11,
                    defaultOrderDirection: 'desc',
                    columnDefs: [{
                        targets: [0, 2, 8],
                        visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }],
                    customButtons: [{
                        text: `<span class="symbol-container cw-btn bg-primary text-light"><i class="bi-plus-circle"></i>Create Card</span>`,
                        action: function(e, dt, node, config) {
                            window.location.href =
                                "{{ route('admin.apps.service_cards.create') }}";
                        },
                    }, ]
                });

                const tabCounters = initTabCounters({
                    countUrl: "{{ route('admin.apps.service_cards.index') }}?get_counts=true",
                    tabCounterMap: {
                        'draft-tab': 'draft',
                        'verified-tab': 'verified',
                        'rejected-tab': 'rejected',
                        'printed-tab': 'printed',
                        'expired-tab': 'expired',
                        'needs-renewal-tab': 'needs_renewal',
                        'lost-tab': 'lost',
                        'duplicate-tab': 'duplicate'
                    },
                    table: table,
                    initialDelay: 500
                });

                hashTabsNavigator({
                    table: table,
                    dataTableUrl: "{{ route('admin.apps.service_cards.index') }}",
                    tabToHashMap: {
                        "#draft-tab": '#draft',
                        "#verified-tab": '#verified',
                        "#rejected-tab": '#rejected',
                        "#printed-tab": '#printed',
                        "#expired-tab": '#expired',
                        "#needs-renewal-tab": '#needs-renewal',
                        "#lost-tab": '#lost',
                        "#duplicate-tab": '#duplicate',
                    },
                    hashToParamsMap: {
                        '#draft': {
                            approval_status: 'draft'
                        },
                        '#verified': {
                            approval_status: 'verified',
                            card_status: 'active'
                        },
                        '#rejected': {
                            approval_status: 'rejected',
                            card_status: 'active'
                        },
                        '#printed': {
                            approval_status: 'verified',
                            printed: true
                        },
                        '#expired': {
                            approval_status: 'verified',
                            card_status: 'expired'
                        },
                        '#needs-renewal': {
                            approval_status: 'verified',
                            needs_renewal: true
                        },
                        '#lost': {
                            approval_status: 'verified',
                            card_status: 'lost'
                        },
                        '#duplicate': {
                            approval_status: 'verified',
                            card_status: 'duplicate'
                        }
                    },
                    defaultHash: '#draft'
                });

                table.on('click', '.verify-btn', async function() {
                    const cardId = $(this).data("id");
                    const url = "{{ route('admin.apps.service_cards.verify', ':id') }}".replace(':id',
                        cardId);

                    const result = await confirmAction('Do you want to Verify this service card?');
                    if (result && result.isConfirmed) {
                        const success = await fetchRequest(url, 'PATCH');
                        if (success) {
                            table.ajax.reload();
                            tabCounters.updateAllTabCounters();
                        }
                    }
                });

                table.on('click', '.reject-btn', async function() {
                    const cardId = $(this).data("id");
                    const url = "{{ route('admin.apps.service_cards.reject', ':id') }}".replace(':id',
                        cardId);

                    const {
                        value: reason
                    } = await confirmWithInput({
                        inputType: "textarea",
                        text: 'Do you want to reject this service card?',
                        inputValidator: (value) => {
                            if (!value) {
                                return 'You need to provide a reason!';
                            }
                        },
                        inputPlaceholder: 'Enter the reason for rejection',
                        confirmButtonText: 'Reject',
                        cancelButtonText: 'Cancel'
                    });

                    if (reason) {
                        const success = await fetchRequest(url, 'PATCH', {
                            reason
                        });
                        if (success) {
                            table.ajax.reload();
                            tabCounters.updateAllTabCounters();
                        }
                    }
                });

                table.on('click', '.renew-btn', async function() {
                    const cardId = $(this).data("id");
                    const url = "{{ route('admin.apps.service_cards.renew', ':id') }}".replace(':id',
                        cardId);

                    const result = await confirmAction(
                        'Do you want to renew this service card? This will create a new card with a 3-year validity.'
                    );
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
                                    window.location.href =
                                        "{{ route('admin.apps.service_cards.show', ':id') }}"
                                        .replace(':id', response.new_card_id);
                                }
                            });
                            table.ajax.reload();
                            tabCounters.updateAllTabCounters();
                        }
                    }
                });

                table.on('click', '.restore-btn', async function() {
                    const cardId = $(this).data("id");
                    const url = "{{ route('admin.apps.service_cards.restore', ':id') }}".replace(':id',
                        cardId);

                    const result = await confirmAction(
                        'Would you like to restore this service card to draft status?');
                    if (result && result.isConfirmed) {
                        const success = await fetchRequest(url, 'PATCH');
                        if (success) {
                            table.ajax.reload();
                            tabCounters.updateAllTabCounters();
                        }
                    }
                });

                table.on('click', '.mark-lost-btn', async function() {
                    const cardId = $(this).data("id");
                    const url = "{{ route('admin.apps.service_cards.markLost', ':id') }}".replace(':id',
                        cardId);

                    const result = await confirmAction('Mark this service card as lost?');
                    if (result && result.isConfirmed) {
                        const success = await fetchRequest(url, 'PATCH');
                        if (success) {
                            table.ajax.reload();
                            tabCounters.updateAllTabCounters();
                        }
                    }
                });

                table.on('click', '.reprint-btn', async function() {
                    const cardId = $(this).data("id");
                    const url = "{{ route('admin.apps.service_cards.reprint', ':id') }}".replace(':id',
                        cardId);

                    const result = await confirmAction('Create a replacement card for this lost card?');
                    if (result && result.isConfirmed) {
                        const success = await fetchRequest(url, 'PATCH');
                        if (success) {
                            table.ajax.reload();
                            tabCounters.updateAllTabCounters();
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
                    fetchUrl: "{{ route('admin.apps.service_cards.showCard', ':id') }}",
                    btnSelector: '.card-btn',
                    title: 'Service Card',
                    modalSize: 'md',
                    actionButtonName: 'PDF',
                    actionButtonClass: 'cw-btn bg-danger px-3',
                    cancelButton: false,
                }).then((modalId) => {
                    const modal = $(`#${modalId}`);
                    const actionBtn = modal.find('button[type="submit"]');
                    const frontBtn = $(
                        '<button type="button" class="cw-btn bg-primary me-2">FRONT</button>');
                    const backBtn = $(
                        '<button type="button" class="cw-btn bg-secondary me-2">BACK</button>');

                    actionBtn.before(frontBtn);
                    frontBtn.before(backBtn);

                    function getCardId() {
                        const urlParams = new URLSearchParams(window.location.search);
                        return urlParams.get('id');
                    }

                    async function checkAndMarkCardAsPrinted() {
                        const cardId = getCardId();

                        const currentHash = window.location.hash;
                        const isPrintedTab = currentHash === '#printed';

                        const cardStatusBadge = modal.find('.badge:contains("Printed")');
                        const isAlreadyPrinted = cardStatusBadge.length > 0;

                        if (isPrintedTab || isAlreadyPrinted) {
                            return true;
                        }

                        const result = await confirmAction(
                            'This will mark the card as printed. Continue?', 'warning');
                        if (result && result.isConfirmed) {
                            const url =
                                "{{ route('admin.apps.service_cards.markPrinted', ':id') }}"
                                .replace(':id', cardId);
                            const response = await fetchRequest(url, 'PATCH');
                            if (response) {
                                table.ajax.reload();
                                tabCounters.updateAllTabCounters();
                                return true;
                            }
                        }
                        return false;
                    }

                    actionBtn.off('click').on('click', async function() {
                        const shouldProceed = await checkAndMarkCardAsPrinted();

                        if (!shouldProceed) {
                            return;
                        }

                        setButtonLoading(actionBtn, true);
                        const front = $('#capture .service-card_front')[0];
                        const back = $('#capture .service-card_back')[0];

                        html2canvas(front, {
                            scale: 3,
                            useCORS: true,
                            logging: false
                        }).then(function(frontCanvas) {
                            const frontImgData = frontCanvas.toDataURL(
                                'image/png');

                            const cardWidth = frontCanvas.width / 3;
                            const cardHeight = frontCanvas.height / 3;

                            const pdf = new window.jspdf.jsPDF({
                                orientation: cardHeight > cardWidth ?
                                    'portrait' : 'landscape',
                                unit: 'px',
                                format: [cardWidth, cardHeight]
                            });

                            pdf.addImage(frontImgData, 'PNG', 0, 0, cardWidth,
                                cardHeight);

                            html2canvas(back, {
                                scale: 3,
                                useCORS: true,
                                logging: false
                            }).then(function(backCanvas) {
                                const backImgData = backCanvas
                                    .toDataURL('image/png');

                                const backWidth = backCanvas.width / 3;
                                const backHeight = backCanvas.height /
                                    3;
                                pdf.addPage([backWidth, backHeight]);
                                pdf.addImage(backImgData, 'PNG', 0, 0,
                                    backWidth, backHeight);
                                pdf.save(
                                    `service-card-${uniqId(6)}.pdf`);
                                setButtonLoading(actionBtn, false);
                                showNotification(
                                    'PDF (Both sides) downloaded successfully',
                                    'success');
                                modal.modal("hide");
                            });
                        });
                    });

                    frontBtn.off('click').on('click', async function() {
                        const shouldProceed = await checkAndMarkCardAsPrinted();

                        if (!shouldProceed) {
                            return;
                        }

                        setButtonLoading(frontBtn, true);
                        var front = $('#capture .service-card_front')[0];
                        html2canvas(front, {
                            scale: 3,
                            useCORS: true,
                            logging: false,
                        }).then(function(canvas) {
                            canvas.toBlob(function(blob) {
                                var link = $('<a></a>')[0];
                                link.href = URL.createObjectURL(blob);
                                link.download =
                                    `service-card-front-${uniqId(6)}.png`;
                                link.click();
                                setButtonLoading(frontBtn, false);
                                showNotification(
                                    'Front side downloaded successfully!',
                                    'success');
                            });
                        });
                    });

                    backBtn.off('click').on('click', async function() {
                        const shouldProceed = await checkAndMarkCardAsPrinted();

                        if (!shouldProceed) {
                            return;
                        }

                        setButtonLoading(backBtn, true);
                        var back = $('#capture .service-card_back')[0];
                        html2canvas(back, {
                            scale: 3,
                            useCORS: true,
                            logging: false
                        }).then(function(canvas) {
                            canvas.toBlob(function(blob) {
                                var link = $('<a></a>')[0];
                                link.href = URL.createObjectURL(blob);
                                link.download =
                                    `service-card-back-${uniqId(6)}.png`;
                                link.click();
                                setButtonLoading(backBtn, false);
                                showNotification(
                                    'Back side downloaded successfully!',
                                    'success');
                            });
                        });
                    });


                });

            });
        </script>
    @endpush
</x-service-card-layout>
