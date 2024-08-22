<x-app-layout>
    @push('style')
        <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
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

    <table id="registrations-datatable" class="table table-striped table-hover">
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
        <script src="{{ asset('js/datatables.min.js') }}"></script>
        <script>
            $(function() {
                var table = $('#registrations-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('registrations.index') }}",
                        data(d) {
                            console.log(d)
                        },
                        error(jqXHR, textStatus, errorThrown) {
                            $("#registrations-datatable").removeClass("data-table-loading");
                            console.log("An error occurred while loading data: " + errorThrown);
                        },
                    },
                    order: [
                        [17, 'desc']
                    ],
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
                    language: {
                        searchBuilder: {
                            button: '<span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="text-gray-600 dark-text-gray-300 mr-1" height="20px" viewBox="0 0 24 24" width="20px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/></svg> &nbsp; Filter</span>'
                        }
                    },
                    layout: {
                        top1Start: {
                            buttons: [{
                                    extend: "collection",
                                    text: '<span class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" class="mr-1" height="20px" viewBox="0 0 24 24" width="20px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/></svg> &nbsp; Export</span>',
                                    autoClose: true,
                                    buttons: [{
                                        extend: "copy",
                                        text: '<span class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" class="mr-3" height="20px" viewBox="0 0 24 24" width="20px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/></svg> &nbsp; Copy</span>',
                                        exportOptions: {
                                            columns: ":visible:not(:last-child)",
                                        },
                                    }, {
                                        extend: "csv",
                                        text: '<span class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" class="mr-3" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M230-360h120v-60H250v-120h100v-60H230q-17 0-28.5 11.5T190-560v160q0 17 11.5 28.5T230-360Zm156 0h120q17 0 28.5-11.5T546-400v-60q0-17-11.5-31.5T506-506h-60v-34h100v-60H426q-17 0-28.5 11.5T386-560v60q0 17 11.5 30.5T426-456h60v36H386v60Zm264 0h60l70-240h-60l-40 138-40-138h-60l70 240ZM160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm0-80h640v-480H160v480Zm0 0v-480 480Z"/></svg> &nbsp; CSV</span>',
                                        exportOptions: {
                                            columns: ":visible:not(:last-child)",
                                        },
                                    }, {
                                        extend: "excel",
                                        text: '<span class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" class="mr-3" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h133v-133H200v133Zm213 0h134v-133H413v133Zm214 0h133v-133H627v133ZM200-413h133v-134H200v134Zm213 0h134v-134H413v134Zm214 0h133v-134H627v134ZM200-627h133v-133H200v133Zm213 0h134v-133H413v133Zm214 0h133v-133H627v133Z"/></svg> &nbsp; Excel</span>',
                                        exportOptions: {
                                            columns: ":visible:not(:last-child)",
                                        },
                                    }, {
                                        extend: "print",
                                        text: '<span class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" class="mr-3" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M640-640v-120H320v120h-80v-200h480v200h-80Zm-480 80h640-640Zm560 100q17 0 28.5-11.5T760-500q0-17-11.5-28.5T720-540q-17 0-28.5 11.5T680-500q0 17 11.5 28.5T720-460Zm-80 260v-160H320v160h320Zm80 80H240v-160H80v-240q0-51 35-85.5t85-34.5h560q51 0 85.5 34.5T880-520v240H720v160Zm80-240v-160q0-17-11.5-28.5T760-560H200q-17 0-28.5 11.5T160-520v160h80v-80h480v80h80Z"/></svg> &nbsp; Print</span>',
                                        autoPrint: false,
                                        exportOptions: {
                                            columns: ":visible:not(:last-child)",
                                        },
                                    }, ],
                                }, {
                                    extend: "colvis",
                                    collectionLayout: 'two-column',
                                    text: '<span class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" class="mr-1" height="20px" viewBox="0 0 24 24" width="20px" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg> &nbsp; Columns</span>',
                                }, {
                                    extend: 'searchBuilder',
                                    config: {
                                        depthLimit: 2
                                    },
                                },
                                {
                                    text: '<span class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" class="mr-1" height="20px" viewBox="0 0 24 24" width="20px" fill="currentColor"><path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg> &nbsp; Reload</span> ',
                                    action: function(e, dt, node, config) {
                                        dt.ajax.reload();
                                    },
                                },
                            ],
                        },
                        topStart: {
                            pageLength: {
                                menu: [
                                    [5, 10, 25, 50, 100, 500, -1],
                                    [5, 10, 25, 50, 100, 500, "All"],
                                ],
                            },
                        },
                        topEnd: {
                            search: {
                                placeholder: "Type search here...",
                            },
                        },
                    },
                    columnDefs: [{
                        targets: [0, 2, 3, 6, 11, 12, 13, 14, 15, 16],
                        visible: false
                    }, ],
                    fnPreDrawCallback() {
                        $("#registrations-datatable").addClass("data-table-loading");
                    },
                    fnDrawCallback() {
                        $("#registrations-datatable").removeClass("data-table-loading");
                    }
                });

                $("#registrations-datatable").on('click', '.defer-btn', function() {
                    var registrationId = $(this).data("id");
                    if (confirm("Are you sure you want to defer?")) {
                        $.ajax({
                            url: "{{ route('registrations.defer', ':id') }}".replace(':id',
                                registrationId),
                            type: "PATCH",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(result) {
                                if (result.success) {
                                    $("#registrations-datatable").DataTable().ajax.reload();
                                }
                            },
                        });
                    }
                });

                $("#registrations-datatable").on('click', '.approve-btn', function() {
                    var registrationId = $(this).data("id");
                    if (confirm("Are you sure you want to approve?")) {
                        $.ajax({
                            url: "{{ route('registrations.approve', ':id') }}".replace(':id',
                                registrationId),
                            type: "PATCH",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(result) {
                                if (result.success) {
                                    $("#registrations-datatable").DataTable().ajax.reload();
                                }
                            },
                        });
                    }
                });

                function updateDataTableURL(deferValue, approvalValue) {
                    let queryParams = "?defer=" + deferValue;
                    if (approvalValue !== undefined) {
                        queryParams += "&approved=" + approvalValue;
                    }
                    registrationsData = "{{ route('registrations.index') }}" + queryParams;
                    table.ajax.url(registrationsData).load();
                }

                function activateTab(tabId) {
                    $('.nav-tabs a[href="' + tabId + '"]').tab('show');
                    $('.tab-pane').removeClass('active show');
                    $(tabId).addClass('active show');
                }

                function getDeferValueFromHash(hash) {
                    switch (hash) {
                        case '#deferred1':
                            return 1;
                        case '#deferred2':
                            return 2;
                        case '#deferred3':
                            return 3;
                        case '#approved':
                            return undefined;
                        default:
                            return 0;
                    }
                }

                $('.nav-tabs a').on('click', function() {
                    let href = $(this).attr('href');
                    window.location.hash = href;
                });

                let initialTab = window.location.hash || '#not-deferred';
                let initialDeferValue = getDeferValueFromHash(initialTab);

                if (initialTab === '#approved') {
                    updateDataTableURL(undefined, 1);
                } else {
                    updateDataTableURL(initialDeferValue);
                }

                activateTab(initialTab);

                $("#tab-defer0").on("click", function() {
                    updateDataTableURL(0);
                });

                $("#tab-defer1").on("click", function() {
                    updateDataTableURL(1);
                });

                $("#tab-defer2").on("click", function() {
                    updateDataTableURL(2);
                });

                $("#tab-defer3").on("click", function() {
                    updateDataTableURL(3);
                });

                $("#tab-approved").on("click", function() {
                    updateDataTableURL(undefined, 1);
                });

            });
        </script>
    @endpush
</x-app-layout>
