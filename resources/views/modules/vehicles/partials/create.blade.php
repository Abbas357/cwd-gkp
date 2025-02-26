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

<main class="cw-wizard m-1">
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
                    @case(2) Model Info @break
                    @case(3) Registration Info @break
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
                    <label for="type">Type</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="">Choose...</option>
                        @foreach ($cat['vehicle_type'] as $type)
                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="color">Color</label>
                    <select class="form-select" id="color" name="color" required>
                        <option value="">Choose...</option>
                        @foreach ($cat['vehicle_color'] as $color)
                        <option value="{{ $color->name }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="fuel_type">Fuel Type</label>
                    <select class="form-select" id="fuel_type" name="fuel_type" required>
                        <option value="">Choose...</option>
                        @foreach ($cat['fuel_type'] as $fuel_type)
                        <option value="{{ $fuel_type->name }}">{{ $fuel_type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="brand">Brand</label>
                    <select class="form-select" id="brand" name="brand" required>
                        <option value="">Choose...</option>
                        @foreach ($cat['vehicle_brand'] as $brand)
                        <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="step-pane" data-step="2">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="functional_status">Functional Status</label>
                    <select class="form-select" id="functional_status" name="functional_status" required>
                        <option value="">Choose...</option>
                        @foreach ($cat['vehicle_functional_status'] as $functional_status)
                        <option value="{{ $functional_status->name }}">{{ $functional_status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="registration_status">Registration Status</label>
                    <select class="form-select" id="registration_status" name="registration_status" required>
                        <option value="">Choose...</option>
                        @foreach ($cat['vehicle_registration_status'] as $registration_status)
                        <option value="{{ $registration_status->name }}">{{ $registration_status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="model">Model*</label>
                    <input type="text" class="form-control" id="model" name="model" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="model_year">Model Year</label>
                    <input type="number" class="form-control" id="model_year" name="model_year" min="1900" max="{{ date('Y')+1 }}">
                </div>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="step-pane" data-step="3">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="registration_number">Registration Number*</label>
                    <input type="text" class="form-control" id="registration_number" name="registration_number" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="chassis_number">Chassis Number</label>
                    <input type="text" class="form-control" id="chassis_number" name="chassis_number">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="engine_number">Engine Number</label>
                    <input type="text" class="form-control" id="engine_number" name="engine_number">
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
                    <label for="rear_view">Rear View</label>
                    <input type="file" class="form-control" id="rear_view" name="rear_view">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="interior_view">Interior View</label>
                    <input type="file" class="form-control" id="interior_view" name="interior_view">
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
            nextBtn.style.display = step === totalSteps ? 'none' : 'block';
        }
    }

    function validateStep(step) {
        const currentPane = document.querySelector(`.step-pane[data-step="${step}"]`);
        if (!currentPane) return true;

        const requiredFields = currentPane.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('invalid');
                isValid = false;
            } else {
                field.classList.remove('invalid');
            }
        });

        return isValid;
    }

    function nextPrev(n) {
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
    }

    document.addEventListener('DOMContentLoaded', () => {
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
                }
            });
        });
    });

</script>
