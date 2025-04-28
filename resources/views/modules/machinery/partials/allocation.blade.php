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
                    <th>Serial Number</th>
                    <td>{{ $machinery->serial_number }}</td>
                    <th>Functional Status</th>
                    <td>{{ $machinery->functional_status }}</td>
                </tr>
                <tr>
                    <th>Model</th>
                    <td>{{ $machinery->model }}</td>
                    <th>Power Source</th>
                    <td>{{ $machinery->power_source }}</td>
                </tr>
                @if($machinery->allocation)
                    <tr>
                        <th>Allocated for</th>
                        <td colspan="3">
                            @if($machinery->allocation->purpose === 'Pool')
                                <span class="badge bg-danger fs-6">Pool</span>
                            @else
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <th>Purpose</th>
                                            <td>{{ $machinery->allocation->purpose }}</td>
                                        </tr>
                                        <tr>
                                            <th>Office</th>
                                            <td>{{ $machinery->allocation->office->name }}</td>
                                        </tr>
                                        @if($machinery->allocation->project_id)
                                        <tr>
                                            <th>Project Name</th>
                                            <td>{{ $machinery->allocation->project->scheme_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Scheme Code</th>
                                            <td>{{ $machinery->allocation->project->scheme_code }}</td>
                                        </tr>
                                        <tr>
                                            <th>ADP Number</th>
                                            <td>{{ $machinery->allocation->project->adp_number }}</td>
                                        </tr>
                                        @endif
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
        <label for="purpose">Allocation Purpose</label>
        <select class="form-select" id="purpose" name="purpose" required>
            <option value="">Choose...</option>
            @foreach (setting('machinery_purpose', 'machinery') as $purpose)
            <option value="{{ $purpose }}">{{ $purpose }}</option>
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
    <div class="col-md-6 mb-3">
        <label class="form-label" for="load-schemes">Project / Scheme</label>
        <select name="project_id" id="load-schemes" class="form-select" data-placeholder="Select Schemes"></select>
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

        select2Ajax(
            '#load-schemes',
            '{{ route("admin.schemes.api") }}',
            {
                placeholder: "Select Scheme",
                dropdownParent: $('#load-schemes').closest('.modal')
            }
        );

        function handlePurposeChange() {
            const selectedPurpose = $('#purpose').val();
            const isPool = selectedPurpose === 'Pool';
            
            const startDateField = $('#start_date');
            const userSelect = $('#load-users');
            const projectSelect = $('#project_id');
            
            if (isPool) {
                startDateField.prop('disabled', true).val('');
                userSelect.prop('disabled', true).val(null).trigger('change');
                projectSelect.prop('disabled', true).val(null).trigger('change');
                
                startDateField.prop('required', false);
                userSelect.prop('required', false);
                projectSelect.prop('required', false);
            } else {
                startDateField.prop('disabled', false);
                userSelect.prop('disabled', false);
                projectSelect.prop('disabled', false);
                
                startDateField.prop('required', true);
                userSelect.prop('required', true);
                projectSelect.prop('required', false);
            }
        }
        
        $('#purpose').on('change', handlePurposeChange);
        
        handlePurposeChange();
    });
</script>