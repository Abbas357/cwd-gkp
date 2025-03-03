<style>
    .cw-wizard .wizard-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 2rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .cw-wizard .wizard-steps {
        margin-bottom: 1.5rem;
    }

    .cw-wizard .step-progress {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 30px;
        max-width: 100%;
        width: 100%;
    }

    .cw-wizard .progress-bar {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        height: 4px;
        background: #e0e0e0;
        width: 100%;
        z-index: 1;
    }

    .cw-wizard .progress-fill {
        position: absolute;
        height: 100%;
        background: #3b5998;
        width: 0%;
        transition: width 0.3s ease;
    }

    .cw-wizard .step-circle {
        width: 40px;
        height: 40px;
        background: white;
        border: 4px solid #e0e0e0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .cw-wizard .step-circle.active {
        border-color: #3b5998;
        background: #3b5998;
        color: white;
    }

    .cw-wizard .step-circle.completed {
        border-color: #3b5998;
        background: #3b5998;
        color: white;
    }

    .cw-wizard .step-number {
        font-weight: bold;
    }

    .cw-wizard .step-label {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-top: 8px;
        white-space: nowrap;
        font-size: 0.875rem;
        color: #666;
    }

    .cw-wizard .step-pane {
        display: none;
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.3s ease;
    }

    .cw-wizard .step-pane.active {
        display: block;
        opacity: 1;
        transform: translateX(0);
    }

    .cw-wizard .wizard-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 1rem;
        padding-top: .7rem;
        border-top: 1px solid #eee;
    }

    .cw-wizard .btn {
        padding: 0.5rem 1.2rem;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .cw-wizard .btn-primary {
        background: #3b5998;
        color: white;
        border: none;
    }

    .cw-wizard .btn-primary:hover {
        background: #253a69;
    }

    .cw-wizard .btn-secondary {
        background: #f5f5f5;
        color: #333;
        border: 1px solid #ddd;
    }

    .cw-wizard .btn-secondary:hover {
        background: #e9e9e9;
    }

    .cw-wizard .form-control.invalid {
        border-color: #dc3545;
    }

    .cw-wizard .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .cw-wizard .form-group {
        position: relative;
    }

    .cw-wizard .form-control.invalid,
    .cw-wizard .form-select.invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .cw-wizard .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #dc3545;
    }

    .cw-wizard .form-control.invalid~.invalid-feedback,
    .cw-wizard .form-select.invalid~.invalid-feedback {
        display: block;
    }

    .cw-wizard .form-control.valid,
    .cw-wizard .form-select.valid {
        border-color: #198754;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

</style>
<main id="machinery-wizard-form" class="cw-wizard m-1">
    <!-- Adding a form tag wrapper -->
    <div class="wizard-steps py-2 px-5" style="background-color: #F0F0F0; border: 1px solid #ccc; border-radius: 10px">
        <div class="step-progress">
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
            @for ($i = 1; $i <= 4; $i++) <div class="step-circle {{ $i == 1 ? 'active' : '' }}" data-step="{{ $i }}">
                <div class="step-number">{{ $i }}</div>
                <div class="step-label">
                    @switch($i)
                    @case(1) Basic Info @break
                    @case(2) Technical Details @break
                    @case(3) Maintenance Info @break
                    @case(4) Images @break
                    @endswitch
                </div>
        </div>
        @endfor
    </div>
    </div>
    <div class="step-content">
        <!-- Step 1 -->
        <div class="step-pane active" data-step="1">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="type">Machinery Type</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="">Choose...</option>
                        @foreach ($cat['machinery_type'] as $type)
                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a machinery type</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="operational_status">Operational Status</label>
                    <select class="form-select" id="operational_status" name="operational_status" required>
                        <option value="">Choose...</option>
                        @foreach ($cat['machinery_operational_status'] as $status)
                        <option value="{{ $status->name }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select an operational status</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="power_source">Power Source</label>
                    <select class="form-select" id="power_source" name="power_source" required>
                        <option value="">Choose...</option>
                        @foreach ($cat['machinery_power_source'] as $power_source)
                        <option value="{{ $power_source->name }}">{{ $power_source->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a power source</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="manufacturer">Manufacturer</label>
                    <select class="form-select" id="manufacturer" name="manufacturer" required>
                        <option value="">Choose...</option>
                        @foreach ($cat['machinery_manufacturer'] as $manufacturer)
                        <option value="{{ $manufacturer->name }}">{{ $manufacturer->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a manufacturer</div>
                </div>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="step-pane" data-step="2">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="model">Model*</label>
                    <input type="text" class="form-control" id="model" name="model" required>
                    <div class="invalid-feedback">Please enter a model</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="manufacturing_year">Manufacturing Year</label>
                    <input type="number" class="form-control" id="manufacturing_year" name="manufacturing_year" min="1900" max="{{ date('Y')+1 }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="serial_number">Serial Number*</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number" required>
                    <div class="invalid-feedback">Please enter a serial number</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="power_rating">Power Rating</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="power_rating" name="power_rating">
                        <span class="input-group-text">HP/kW</span>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="operating_hours">Operating Hours</label>
                    <input type="number" class="form-control" id="operating_hours" name="operating_hours" min="0">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="asset_tag">Asset Tag</label>
                    <input type="text" class="form-control" id="asset_tag" name="asset_tag">
                </div>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="step-pane" data-step="3">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="location">Location</label>
                    <select class="form-select" id="location" name="location">
                        <option value="">Choose...</option>
                        @foreach ($cat['machinery_location'] as $location)
                        <option value="{{ $location->name }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="certification_status">Certification Status</label>
                    <select class="form-select" id="certification_status" name="certification_status">
                        <option value="">Choose...</option>
                        @foreach ($cat['machinery_certification_status'] as $status)
                        <option value="{{ $status->name }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="last_maintenance_date">Last Maintenance Date</label>
                    <input type="date" class="form-control" id="last_maintenance_date" name="last_maintenance_date">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="next_maintenance_date">Next Maintenance Date</label>
                    <input type="date" class="form-control" id="next_maintenance_date" name="next_maintenance_date">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="hourly_cost">Hourly Cost</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="hourly_cost" name="hourly_cost" step="0.01" min="0">
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="specifications">Technical Specifications</label>
                    <textarea class="form-control" id="specifications" name="specifications" rows="2"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
                </div>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="step-pane" data-step="4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="front_view">Front View</label>
                    <input type="file" class="form-control" id="front_view" name="front_view">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="side_view">Side View</label>
                    <input type="file" class="form-control" id="side_view" name="side_view">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="control_panel">Control Panel</label>
                    <input type="file" class="form-control" id="control_panel" name="control_panel">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nameplate">Nameplate/Serial Number</label>
                    <input type="file" class="form-control" id="nameplate" name="nameplate">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="certification_doc">Certification Document</label>
                    <input type="file" class="form-control" id="certification_doc" name="certification_doc">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="manual">Operation Manual</label>
                    <input type="file" class="form-control" id="manual" name="manual" accept=".pdf,.doc,.docx">
                </div>
            </div>
        </div>
    </div>

    <div class="wizard-footer">
        <button type="button" class="btn btn-secondary" id="prevBtn" onclick="nextPrev(-1)">Back</button>
        <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
</main>

<script>
    let currentStep = 1;
    const totalSteps = 4;

    function updateProgressBar() {
        const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
        const progressFill = document.querySelector('.progress-fill');
        if (progressFill) {
            progressFill.style.width = `${progress}%`;
        }
    }

    function updateSteps() {
        document.querySelectorAll('.step-circle').forEach((step, index) => {
            const stepNum = index + 1;
            step.classList.remove('active', 'completed');
            if (stepNum === currentStep) {
                step.classList.add('active');
            } else if (stepNum < currentStep) {
                step.classList.add('completed');
            }
        });
    }

    function showStep(step) {
        document.querySelectorAll('.step-pane').forEach(pane => {
            pane.classList.remove('active');
        });

        const targetPane = document.querySelector(`.step-pane[data-step="${step}"]`);
        if (targetPane) {
            targetPane.classList.add('active');
        }

        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        if (prevBtn && nextBtn) {
            prevBtn.style.display = step === 1 ? 'none' : 'block';
            
            if (step === totalSteps) {
                nextBtn.innerHTML = 'Submit';
                nextBtn.type = 'submit'; // Change to submit on last step
            } else {
                nextBtn.innerHTML = 'Next';
                nextBtn.type = 'button';
            }
        }
    }

    function validateStep(step) {
        const currentPane = document.querySelector(`.step-pane[data-step="${step}"]`);
        if (!currentPane) return true;

        const requiredFields = currentPane.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            // Reset validation state first
            field.classList.remove('invalid');
            
            // Check if field is empty
            if (!field.value.trim()) {
                field.classList.add('invalid');
                isValid = false;
                
                // Show feedback
                const feedback = field.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.style.display = 'block';
                }
            }
        });

        return isValid;
    }

    function nextPrev(n) {
        // Hide any previous validation messages
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.style.display = 'none';
        });
        
        if (n === 1 && !validateStep(currentStep)) {
            return false;
        }

        const newStep = currentStep + n;
        if (newStep > 0 && newStep <= totalSteps) {
            currentStep = newStep;
            showStep(currentStep);
            updateSteps();
            updateProgressBar();
        }
        
        // If this is the final submit action
        if (n === 1 && currentStep > totalSteps) {
            document.getElementById('machinery-wizard-form').submit();
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Show the back button as none on first load
        document.getElementById('prevBtn').style.display = 'none';
        
        showStep(currentStep);
        updateSteps();
        updateProgressBar();

        document.querySelectorAll('.step-circle').forEach(circle => {
            circle.addEventListener('click', () => {
                const clickedStep = parseInt(circle.getAttribute('data-step'));
                if (clickedStep < currentStep || validateStep(currentStep)) {
                    currentStep = clickedStep;
                    showStep(currentStep);
                    updateSteps();
                    updateProgressBar();
                }
            });
        });

        document.querySelectorAll('input[required], select[required]').forEach(field => {
            field.addEventListener('input', () => {
                if (field.value.trim()) {
                    field.classList.remove('invalid');
                    // Hide feedback
                    const feedback = field.nextElementSibling;
                    if (feedback && feedback.classList.contains('invalid-feedback')) {
                        feedback.style.display = 'none';
                    }
                }
            });
            
            field.addEventListener('change', () => {
                if (field.value.trim()) {
                    field.classList.remove('invalid');
                    // Hide feedback
                    const feedback = field.nextElementSibling;
                    if (feedback && feedback.classList.contains('invalid-feedback')) {
                        feedback.style.display = 'none';
                    }
                }
            });
        });
        
        // Prevent default form submission
        document.getElementById('machinery-wizard-form').addEventListener('submit', function(event) {
            // You can add final validation here if needed
            // If you want to prevent actual submission for any reason:
            // event.preventDefault();
        });
    });
</script>