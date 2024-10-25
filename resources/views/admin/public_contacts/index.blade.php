<x-app-layout title="Public Contact">
    @push('style')
    <link href="{{ asset('admin/plugins/datatable/css/datatables.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Public Contact</li>
    </x-slot>

    <div class="card-header mb-3 d-flex justify-content-between">
        <ul class="nav nav-tabs nav-tabs-table">
            <li class="nav-item">
                <a id="new-tab" class="nav-link" data-bs-toggle="tab" href="#new">New</a>
            </li>
            <li class="nav-item">
                <a id="relief-granted-tab" class="nav-link" data-bs-toggle="tab" href="#relief-granted">Relief Granted</a>
            </li>
            <li class="nav-item">
                <a id="relief-not-granted-tab" class="nav-link" data-bs-toggle="tab" href="#relief-not-granted">Relief Not Granted</a>
            </li>
            <li class="nav-item">
                <a id="dropped-tab" class="nav-link" data-bs-toggle="tab" href="#dropped">Dropped</a>
            </li>
        </ul>
    </div>

    <table id="public_contact-datatable" width="100%" class="table table-striped table-hover table-bordered align-center">
        <thead>
            <tr>
                <th scope="col" class="p-3">ID</th>
                <th scope="col" class="p-3">Name</th>
                <th scope="col" class="p-3">Email</th>
                <th scope="col" class="p-3">Contact Number</th>
                <th scope="col" class="p-3">CNIC</th>
                <th scope="col" class="p-3">Message</th>
                <th scope="col" class="p-3">Device Info</th>
                <th scope="col" class="p-3">Status</th>
                <th scope="col" class="p-3">Created At</th>
                <th scope="col" class="p-3">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <!--end row-->
    @push('script')
    <script src="{{ asset('admin/plugins/datatable/js/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/col-resizable.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = initDataTable('#public_contact-datatable', {
                ajaxUrl: "{{ route('admin.public_contact.index') }}"
                , columns: [{
                        data: "id"
                        , searchBuilderType: "num"
                    }
                    , {
                        data: "name"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "email"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "contact_number"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "cnic"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "message"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "device_info"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "status"
                        , searchBuilderType: "string"
                    }
                    , {
                        data: "created_at"
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
                    targets: [0]
                    , visible: false
                }]
            });

            hashTabsNavigator({
                table: table
                , dataTableUrl: "{{ route('admin.public_contact.index') }}"
                , tabToHashMap: {
                    "#new-tab": '#new'
                    , "#relief-granted-tab": '#relief-granted'
                    , "#relief-not-granted-tab": '#relief-not-granted'
                    , "#dropped-tab": '#dropped'
                , }
                , hashToParamsMap: {
                    '#new': {
                        status: 'new'
                    }
                    , '#relief-granted': {
                        status: 'relief-granted'
                    }
                    , '#relief-not-granted': {
                        status: 'relief-not-granted'
                    }
                    , '#dropped': {
                        status: 'dropped'
                    }
                , }
                , defaultHash: '#new'
            });

            $("#public_contact-datatable").on('click', '.relief-grant-btn', async function() {
                const contactId = $(this).data("id");
                const url = "{{ route('admin.public_contact.grant', ':id') }}".replace(':id', contactId);

                const {
                    value: remarks
                } = await confirmWithInput({
                    inputType: "textarea",
                    text: 'Do you want to grant relief to this person'
                    , inputValidator: (value) => {
                        if (!value) {
                            return 'You need to provide some detail!';
                        }
                    }
                    , inputPlaceholder: 'Detail About Relief Granting'
                    , confirmButtonText: 'Grant Relief'
                    , cancelButtonText: 'Cancel'
                });

                if (remarks) {
                    const success = await fetchRequest(url, 'PATCH', {
                        remarks
                    });
                    if (success) {
                        $("#public_contact-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#public_contact-datatable").on('click', '.relief-not-grant-btn', async function() {
                const contactId = $(this).data("id");
                const url = "{{ route('admin.public_contact.notgrant', ':id') }}".replace(':id', contactId);

                const {
                    value: remarks
                } = await confirmWithInput({
                    inputType: "textarea",
                    text: 'Do you want to not grant relief to this person'
                    , inputValidator: (value) => {
                        if (!value) {
                            return 'You need to provide some detail!';
                        }
                    }
                    , inputPlaceholder: 'Details About not Granting the Relief'
                    , confirmButtonText: 'No Relief Grant'
                    , cancelButtonText: 'Cancel'
                });

                if (remarks) {
                    const success = await fetchRequest(url, 'PATCH', {
                        remarks
                    });
                    if (success) {
                        $("#public_contact-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $("#public_contact-datatable").on('click', '.dropped-btn', async function() {
                const contactId = $(this).data("id");
                const url = "{{ route('admin.public_contact.drop', ':id') }}".replace(':id', contactId);

                const {
                    value: remarks
                } = await confirmWithInput({
                    inputType: "textarea",
                    text: 'Do you want to drop this record'
                    , inputValidator: (value) => {
                        if (!value) {
                            return 'You need to provide some detail!';
                        }
                    }
                    , inputPlaceholder: 'Details About dropping the record'
                    , confirmButtonText: 'Drop'
                    , cancelButtonText: 'Cancel'
                });

                if (remarks) {
                    const success = await fetchRequest(url, 'PATCH', {
                        remarks
                    });
                    if (success) {
                        $("#public_contact-datatable").DataTable().ajax.reload();
                    }
                }
            });

            $('#public_contact-datatable').colResizable({
                liveDrag: true
                , resizeMode: 'overflow'
                , postbackSafe: true
                , useLocalStorage: true
                , gripInnerHtml: "<div class='grip'></div>"
                , draggingClass: "dragging"
            , });

        });

    </script>
    @endpush
</x-app-layout>
