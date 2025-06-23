<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">

<style>
    .table td, .table th {
        padding: .4rem !important;
        vertical-align: middle;
    }

    .vehicle-info {
        background: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>
 
<div class="row vehicle-details">
    <div class="col-md-12">
        <table class="table table-striped table-bordered" style="box-shadow: 0 0 15px #00000033">
            <tbody>
                <tr>
                    <th>Vehicle Type</th>
                    <td>{{ $vehicle->type }}</td>
                    <th>Year</th>
                    <td>{{ $vehicle->model_year }}</td>
                </tr>
                <tr>
                    <th>Reg Number</th>
                    <td>{{ $vehicle->registration_number }}</td>
                    <th>Functional Status</th>
                    <td>{{ $vehicle->functional_status }}</td>
                </tr>
                <tr>
                    <th>Model</th>
                    <td>{{ $vehicle->model }}</td>
                    <th>Fuel Type</th>
                    <td>{{ $vehicle->fuel_type }}</td>
                </tr>
                @if($vehicle->allotment)
                    <tr>
                        <th>Alloted to</th>
                        <td colspan="3">
                            @if($vehicle->allotment->type === 'Pool')
                                @if($vehicle->allotment->office_id)
                                    <span class="badge bg-warning fs-6">Office Pool</span>
                                    <span class="badge bg-info fs-6">{{ $vehicle->allotment->office->name ?? 'No Office' }}</span>
                                @elseif($vehicle->allotment->user_id)
                                    {{-- Legacy data structure where pool vehicles had user_id --}}
                                    <span class="badge bg-warning fs-6">Office Pool</span>
                                    <span class="badge bg-info fs-6">{{ $vehicle->allotment->user->currentPosting?->office?->name ?? 'No Office' }}</span>
                                    <div class="mt-1 small text-muted">(Managed by: {{ $vehicle->allotment->user->name }})</div>
                                @else
                                    <span class="badge bg-danger fs-6">Department Pool</span>
                                @endif
                            @elseif($vehicle->allotment->type === 'Permanent' || $vehicle->allotment->type === 'Temporary')
                                @if($vehicle->allotment->user_id)
                                    <div class="d-flex justify-content-between">
                                        <span class="badge bg-primary fs-6">{{ $vehicle->allotment->type }}</span>
                                        <span class="badge bg-success fs-6">Personal Assignment</span>
                                    </div>
                                    <table class="table table-sm mt-2 mb-0 border">
                                        <tbody>
                                            <tr>
                                                <th class="bg-light">Name</th>
                                                <td>{{ $vehicle->allotment->user->name ?? 'No Name' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Designation</th>
                                                <td>{{ $vehicle->allotment->user->currentPosting?->designation?->name ?? 'Designation Missing' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Office</th>
                                                <td>{{ $vehicle->allotment->user->currentPosting?->office?->name ?? 'Office Missing' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @elseif($vehicle->allotment->office_id)
                                    <div class="d-flex justify-content-between">
                                        <span class="badge bg-primary fs-6">{{ $vehicle->allotment->type }}</span>
                                        <span class="badge bg-warning fs-6">Office Assignment</span>
                                    </div>
                                    <table class="table table-sm mt-2 mb-0 border">
                                        <tbody>
                                            <tr>
                                                <th class="bg-light">Office</th>
                                                <td>{{ $vehicle->allotment->office->name ?? 'Office Missing' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <p>Assignment information not available.</p>
                                @endif
                            @else
                                <span class="badge bg-secondary fs-6">{{ $vehicle->allotment->type ?? 'Unknown Type' }}</span>
                            @endif
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>


<div class="row allot-vehicle mt-4">
    <div class="col-md-6 mb-3">
        <label for="type">Allotment Type</label>
        <select class="form-select" id="type" name="type" required>
            <option value="">Choose...</option>
            @foreach ($cat['allotment_type'] as $type)
            <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>
    </div>
    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
    <div class="col-md-6 mb-3">
        <label for="start_date">Allotment Date</label>
        <input type="date" class="form-control" id="start_date" placeholder="Start Date" name="start_date" value="{{ old('start_date') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="end_date">Return Date <span class="badge bg-secondary mb-1">Optional</span></label>
        <input type="date" class="form-control" id="end_date" placeholder="End Date" name="end_date" value="{{ old('end_date') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="allotment_order">Allotment Order <span class="badge bg-secondary mb-1">Optional</span></label>
        <input type="file" class="form-control" id="allotment_order" placeholder="Allotment Order" name="allotment_order">
    </div>
    <div class="col-md-12" id="user-selection" style="display: none;">
        <label class="form-label" for="load-users">Allot to User</label>
        <select name="user_id" id="load-users" class="form-select"></select>
    </div>
    <div class="col-md-12" id="office-selection" style="display: none;">
        <label class="form-label" for="load-offices">Allot to Office</label>
        <select name="office_id" id="load-offices" class="form-select"></select>
    </div>
    <div class="d-flex justify-content-end mt-1">
        <button type="button" class="btn btn-light border" onclick="openUserQuickCreateModal(onUserCreated)">
            <i class="bi-person-plus"></i> Add User
        </button>
    </div>

</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>

<script>
    $(document).ready(function () {

        imageCropper({
            fileInput: '#allotment_order'
            , aspectRatio: 2 / 3
        });

        select2Ajax(
            '#load-users',
            '{{ route("admin.apps.hr.users.api") }}',
            {
                placeholder: "Select User",
                dropdownParent: $('#load-users').closest('.modal')
            }
        );

        select2Ajax(
            '#load-offices',
            '{{ route("admin.apps.hr.offices.api") }}',
            {
                placeholder: "Select Office",
                dropdownParent: $('#load-offices').closest('.modal')
            }
        );

        $('#type').on('change', function() {
            const selectedType = $(this).val();
            console.log(selectedType);
            if (selectedType === 'Pool') {
                $('#office-selection').show();
                $('#user-selection').hide();
            } else if (selectedType === 'Permanent' || selectedType === 'Temporary') {
                $('#user-selection').show();
                $('#office-selection').hide();
            } else {
                $('#user-selection').hide();
                $('#office-selection').hide();
            }
        });
    });
</script>
