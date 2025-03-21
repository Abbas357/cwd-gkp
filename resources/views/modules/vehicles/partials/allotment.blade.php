<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">

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
                                @if(!empty($vehicle->allotment->user_id))
                                    <span class="badge bg-warning fs-6">Office Pool</span>
                                    <span class="badge bg-warning fs-6">{{ optional(optional(optional(optional($vehicle->allotment)->user)->currentPosting)->office)->name ?? 'No Office' }}</span>
                                @else
                                    <span class="badge bg-danger fs-6">Department Pool</span>
                                @endif
                            @else
                                @if(isset($vehicle->allotment->user))
                                    <table class="table mb-0">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td>{{ optional(optional($vehicle->allotment)->user)->name ?? 'No Name' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Designation</th>
                                                <td>{{ optional(optional(optional(optional($vehicle->allotment)->user)->currentPosting)->designation)->name ?? 'Designation Missing' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Office</th>
                                                <td>{{ optional(optional(optional(optional($vehicle->allotment)->user)->currentPosting)->office)->name ?? 'Office Missing' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <p>User information not available.</p>
                                @endif
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
    <div class="col-md-12">
        <label class="form-label" for="load-users">Allot to User / Office</label>
        <select name="user_id" id="load-users" class="form-select" data-placeholder="Select User / Office">
            <option value=""></option>
            @foreach(App\Models\User::all() as $user)
                <option value="{{ $user->id }}">
                    {{ $user->currentPosting?->office->name }} - {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="d-flex justify-content-end mt-1">
        <button type="button" class="btn btn-light border" onclick="openUserQuickCreateModal(onUserCreated)">
            <i class="bi-person-plus"></i> Add User
        </button>
    </div>

</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
<script>
    $(document).ready(function () {
        const userSelect = $('#load-users');
        userSelect.select2({
            theme: "bootstrap-5",
            dropdownParent: $('#load-users').closest('.modal'),
            placeholder: "Select User / Office",
            allowClear: true,
            ajax: {
                url: '{{ route("admin.apps.hr.users.api") }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    
                    return {
                        results: data.results,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            },
            templateResult: function(user) {
                if (user.loading) {
                    return 'Loading...';
                }
                return user.text;
            },
            templateSelection: function(user) {
                return user.text || 'Select User / Office';
            }
        });

        $("#start_date").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i:S",
        });

        $("#end_date").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i:S",
        });
    });
</script>
