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
            <li class="nav-item">
                <a id="rejected-tab" class="nav-link" data-bs-toggle="tab" href="#rejected">Rejected</a>
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

    <div class="modal fade" id="generate-card" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="loading-spinner text-center mt-2">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="card-details p-1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="generate-image" class="btn btn-primary px-3">Download Card</button>
                </div>
            </div>
        </div>
    </div>

    <!--end row-->
    @push('script')
    <script src="{{ asset('plugins/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/col-resizable.js') }}"></script>
    <script src="{{ asset('plugins/html2canvas/html2canvas.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#generate-image').on('click', function() {
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
            });

            var table = initDataTable('#standardizations-datatable', {
                ajaxUrl: "{{ route('standardizations.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "product_name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "specification_details"
                        , searchBuilderType: "string"
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
                        data: "phone_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "email"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "locality"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "ntn_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "location_type"
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
                , defaultOrderColumn: 11
                , defaultOrderDirection: 'desc'
                , columnDefs: [{
                    targets: [0, 2, 5, 8, 10]
                    , visible: false
                }]
            });

            $("#standardizations-datatable").on('click', '.approve-btn', async function() {
                const standardizationId = $(this).data("id");
                const url = "{{ route('standardizations.approve', ':id') }}".replace(':id', standardizationId);

                const result = await confirmAction('Do you want to approve this product?');
                if (result && result.isConfirmed) {
                    const success = await fetchRequest(url, 'PATCH');
                    if (success) {
                        $("#standardizations-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#standardizations-datatable").on('click', '.reject-btn', async function() {
                const standardizationId = $(this).data("id");
                const url = "{{ route('standardizations.reject', ':id') }}".replace(':id', standardizationId);

                const {
                    value: reason
                } = await confirmWithInput({
                    text: 'Do you want to reject this product?'
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
                        $("#standardizations-datatable").DataTable().ajax.reload();
                    }
                }
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('standardizations.index') }}"
                , tabToHashMap: {
                    "#new-tab": '#new'
                    , "#approved-tab": '#approved'
                    , "#rejected-tab": '#rejected'
                , }
                , hashToParamsMap: {
                    '#new': {
                        approved: 0
                    }
                    , '#approved': {
                        approved: 1
                    }
                    , '#rejected': {
                        approved: 2
                    }
                , }
                , defaultHash: '#new'
            });

            $('#standardizations-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });


            async function openModalFromUrl() {
                const urlParams = new URLSearchParams(window.location.search);
                const standardizationId = urlParams.get('id');
                const url = "{{ route('standardizations.showCard', ':EStandardization') }}".replace(':EStandardization', standardizationId);

                if (standardizationId) {
                    $('#generate-card').modal('show');
                    $('#generate-card .loading-spinner').show();
                    $('#generate-card .card-details').hide();

                    const data = await fetchRequest(url);
                    let standardization = data.standardization;
                    if (standardization) {
                        $('#generate-card .modal-title').text('Standardization Card');
                        $('#generate-card .card-details').html(standardization);
                    } else {
                        $('#generate-card .modal-title').text('Error');
                        $('#generate-card .user-details').html('<p class="pb-0 pt-3 p-4">Unable to generate Card.</p>');
                    }

                    $('#generate-card .loading-spinner').hide();
                    $('#generate-card .card-details').show();
                }
            }

            $(document).on('click', '.card-btn', function() {
                const standardizationId = $(this).data('id');
                const currentHash = window.location.hash;
                const newUrl = `${window.location.pathname}?id=${standardizationId}${currentHash}`;
                history.pushState(null, null, newUrl);
                openModalFromUrl();
            });

            $(window).on('popstate', function() {
                openModalFromUrl();
            });

            $('#generate-card').on('hidden.bs.modal', function() {
                const currentUrl = new URL(window.location);
                currentUrl.searchParams.delete('id');
                const newUrl = `${currentUrl.pathname}${window.location.hash}`;
                history.pushState(null, null, newUrl);
            });
            openModalFromUrl();

        });

    </script>
    @endpush
</x-app-layout>
