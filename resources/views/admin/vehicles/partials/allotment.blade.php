<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">

<style>
    .table td, .table th {
        padding: .5rem !important;
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
        <table class="table table-striped table-bordered">
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
                                <span class="badge bg-danger fs-6">Pool</span>
                            @else
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $vehicle->allotment->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Designation</th>
                                            <td>{{ $vehicle->allotment->user->position }}</td>
                                        </tr>
                                    </tbody>
                                </table>
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
    <div class="col-md-12 mb-3">
        <label for="load-users">Allot to</label>
        <select class="form-select form-select-md" data-placeholder="Choose" id="load-users" name="user_id"></select>
    </div>
</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
<script>
    $(document).ready(function () {
        const userSelect = $('#load-users');
        userSelect.select2({
            theme: "bootstrap-5",
            placeholder: "Select User / Office",
            allowClear: true,
            ajax: {
                url: '{{ route("admin.users.api") }}',
                dataType: 'json',
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 0,
            templateResult: function(user) {
                if (user.loading) return user.text;
                return user.position;
            },
            templateSelection: function(user) {
                return user.position || 'Select User / Office'; // Fallback text
            }
        });

        $("#start_date").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i:S",
        });

        function handleAllotmentTypeChange() {
            const selectedType = $('#type').val();
            const isPool = selectedType === 'Pool';
            
            const startDateField = $('#start_date');
            const userSelect = $('#load-users');
            
            if (isPool) {
                startDateField.prop('disabled', true).val('');
                userSelect.prop('disabled', true).val(null).trigger('change');
                
                startDateField.prop('required', false);
                userSelect.prop('required', false);
            } else {
                startDateField.prop('disabled', false);
                userSelect.prop('disabled', false);
                
                startDateField.prop('required', true);
                userSelect.prop('required', true);
            }
        }
        
        $('#type').on('change', handleAllotmentTypeChange);
        
        handleAllotmentTypeChange();
    });
</script>
