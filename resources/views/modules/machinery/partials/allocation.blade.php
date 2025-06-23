<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">

<style>
    .table td, .table th {
        padding: .4rem !important;
        vertical-align: middle;
    }

    .machinery-info {
        background: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="row machinery-details">
    <div class="col-md-12">
        <table class="table table-striped table-bordered" style="box-shadow: 0 0 15px #00000033">
            <tbody>
                <tr>
                    <th>Machinery Type</th>
                    <td>{{ $machinery->type }}</td>
                    <th>Year</th>
                    <td>{{ $machinery->model_year }}</td>
                </tr>
                <tr>
                    <th>Engine Number</th>
                    <td>{{ $machinery->engine_number }}</td>
                    <th>Functional Status</th>
                    <td>{{ $machinery->functional_status }}</td>
                </tr>
                <tr>
                    <th>Model</th>
                    <td>{{ $machinery->model }}</td>
                    <th>Registration Number</th>
                    <td>{{ $machinery->registration_number }}</td>
                </tr>
                @if($machinery->allocation)
                    <tr>
                        <th>Allocated for</th>
                        <td colspan="3">
                            @if($machinery->allocation->type === 'Pool')
                                <span class="badge bg-danger fs-6">Pool</span>
                            @else
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <th>Allocation Type</th>
                                            <td>{{ $machinery->allocation->type }}</td>
                                        </tr>
                                        <tr>
                                            <th>Office</th>
                                            <td>{{ $machinery?->allocation?->office?->name ?? "N/A" }}</td>
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

<div class="row allocate-machinery mt-4">
    <div class="col-md-6 mb-3">
        <label for="type">Allocation</label>
        <select class="form-select" id="type" name="type" required>
            <option value="">Choose...</option>
            @foreach ($cat['allocation_type'] as $type)
            <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>
    </div>
    <input type="hidden" name="machinery_id" value="{{ $machinery->id }}">
    <div class="col-md-6 mb-3">
        <label for="start_date">Start Date</label>
        <input type="date" class="form-control" id="start_date" placeholder="Start Date" name="start_date" value="{{ old('start_date') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="end_date">End Date <span class="badge bg-secondary mb-1">Optional</span></label>
        <input type="date" class="form-control" id="end_date" placeholder="End Date" name="end_date" value="{{ old('end_date') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label for="machiery_allocation_orders">Allocation Orders <span class="badge bg-secondary mb-1">Optional</span></label>
        <input type="file" class="form-control" id="machiery_allocation_orders" placeholder="Allocation Orders" name="machiery_allocation_orders">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="load-offices">Office</label>
        <select name="office_id" id="load-offices" class="form-select" data-placeholder="Select Office"></select>
    </div>
</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function () {
        select2Ajax(
            '#load-offices',
            '{{ route("admin.apps.hr.offices.api") }}',
            {
                placeholder: "Select Office",
                dropdownParent: $('#load-offices').closest('.modal')
            }
        );

        function handlePurposeChange() {
            const selectedPurpose = $('#type').val();
            const isPool = selectedPurpose === 'Pool';
            
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
        
        $('#type').on('change', handlePurposeChange);
        
        handlePurposeChange();
    });
</script>