<x-hr-layout title="Manage Postings">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Postings</li>
    </x-slot>

    <div class="inward-tabs mb-3">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="current-tab" class="nav-link" data-bs-toggle="tab" href="#current">Current</a>
            </li>
            <li class="nav-item">
                <a id="historical-tab" class="nav-link" data-bs-toggle="tab" href="#historical">Historical</a>
            </li>
        </ul>
    </div>

    <div class="table-responsive">
        <table id="postings-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">User</th>
                    <th scope="col">Office</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Type</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Is Head</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/datatable/js/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = initDataTable('#postings-datatable', {
                ajaxUrl: "{{ route('admin.apps.hr.postings.index') }}",
                columns: [
                    { data: "id", searchBuilderType: "num" },
                    { data: "user", searchBuilderType: "string" },
                    { data: "office", searchBuilderType: "string" },
                    { data: "designation", searchBuilderType: "string" },
                    { data: "type", searchBuilderType: "string" },
                    { data: "start_date", searchBuilderType: "date" },
                    { data: "end_date", searchBuilderType: "date" },
                    { data: "is_head", searchBuilderType: "string" },
                    { data: 'action', orderable: false, searchable: false, type: "html" }
                ],
                defaultOrderColumn: 6,
                defaultOrderDirection: 'desc',
                columnDefs: [
                    { targets: [0], visible: false
                    }, {
                        targets: -1,
                        className: 'action-column'
                    }
                ],
                pageLength: 25,
                customButton: {
                    text: `<span class="symbol-container create-btn fw-bold"><i class="bi-plus-circle"></i>&nbsp; New Posting</span>`,
                    action: function(e, dt, node, config) {

                        formWizardModal({
                            title: 'Add Posting',
                            fetchUrl: "{{ route('admin.apps.hr.postings.create') }}",
                            btnSelector: '.create-btn',
                            actionButtonName: 'Add Posting',
                            modalSize: 'lg',
                            formAction: "{{ route('admin.apps.hr.postings.store') }}",
                            wizardSteps: [
                                {
                                    title: "Basic Info",
                                    fields: ["#step-1"]
                                },
                                {
                                    title: "Posting",
                                    fields: ["#step-2"]
                                },
                                {
                                    title: "Roles",
                                    fields: ["#step-3"]
                                },
                            ],
                            formSubmitted() {
                                table.ajax.reload();
                            }
                        });

                    }
                }
            });

            hashTabsNavigator({
                table: table,
                dataTableUrl: "{{ route('admin.apps.hr.postings.index') }}",
                tabToHashMap: {
                    "#current-tab": '#current',
                    "#historical-tab": '#historical'
                },
                hashToParamsMap: {
                    '#current': {
                        status: 'current'
                    },
                    '#historical': {
                        status: 'historical'
                    }
                },
                defaultHash: '#current'
            });

            $("#postings-datatable").on('click', '.end-posting-btn', async function() {
                const postingId = $(this).data("id");
                const result = await confirmWithInput({
                    text: "Enter end date for this posting",
                    inputType: "date",
                    inputValidator: (value) => {
                        if (!value) {
                            return 'You need to enter an end date';
                        }
                    }
                });

                if (result.isConfirmed) {
                    const url = "{{ route('admin.apps.hr.postings.end', ':id') }}".replace(':id', postingId);
                    const success = await fetchRequest(url, 'PATCH', { end_date: result.value });
                    if (success) {
                        $("#postings-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#postings-datatable").on('click', '.delete-btn', async function() {
                const postingId = $(this).data("id");
                const url = "{{ route('admin.apps.hr.postings.destroy', ':id') }}".replace(':id', postingId);
                const result = await confirmAction("Do you want to delete this posting? This action cannot be undone.");

                if (result.isConfirmed) {
                    const success = await fetchRequest(url, 'DELETE');
                    if (success) {
                        $("#postings-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#postings-datatable").on('change', '.is-head-switch', async function() {
                const postingId = $(this).data("id");
                const isHead = $(this).prop('checked') ? 1 : 0;
                const $switch = $(this);
                $switch.prop('disabled', true);

                const url = "{{ route('admin.apps.hr.postings.update-head', ':id') }}".replace(':id', postingId);
                
                const success = await fetchRequest(url, 'PATCH', { is_head: isHead });
                if (success) {
                    $switch.prop('disabled', false);
                    $("#postings-datatable").DataTable().ajax.reload();
                } else {
                    $switch.prop('checked', !isHead);
                    $switch.prop('disabled', false);
                }
            });

        });
    </script>
    @endpush
</x-hr-layout>