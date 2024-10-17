<x-main-layout title="Standardization of Engineering Products / Materials">
    @push('style')
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <div class="wrapper">
        <div class="page container">
            <div class="page-inner">
                <header class="page-title-bar">
                    <h1 class="page-title fs-3 py-2 bg-light px-2">Standardization of Engineering Products / Materials</h1>
                </header>
                <div class="page-section shadow-lg rounded bg-light" style="border:1px solid #ccc">
                    <form class="needs-validation" action="{{ route('standardizations.store') }}" method="post" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card m-2 shadow border border-light rounded border-2">
                                    <div class="card-body">
                                        <h3 class="card-title">Fill all the fields</h3>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="product_name">Product Name <abbr title="Required">*</abbr></label>
                                                <input type="text" class="form-control" id="product_name" value="{{ old('product_name') }}" placeholder="Name of Owner" name="product_name" required>
                                                @error('product_name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="specification_details">Specification Details <abbr title="Required">*</abbr></label>
                                                <textarea name="specification_details" id="specification_details" class="form-control w-100"></textarea>
                                                @error('specification_details')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="firm_name">Name of Firm / Supplier / Manufacturer <abbr title="Required">*</abbr></label>
                                                <input type="text" class="form-control" id="firm_name" value="{{ old('firm_name') }}" placeholder="Name of Firm / Supplier / Manufacturer" name="firm_name" required>
                                                @error('firm_name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email">Email <abbr title="Required">*</abbr></label>
                                                <input type="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Email" name="email" required>
                                                @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="address">Address <abbr title="Required">*</abbr></label>
                                                <input type="text" class="form-control" id="address" value="{{ old('address') }}" placeholder="Address" name="address" required>
                                                @error('address')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="phone_number">Phone Number <abbr title="Required">*</abbr></label>
                                                <input type="text" class="form-control" id="phone_number" value="{{ old('phone_number') }}" placeholder="Phone Number" name="phone_number" required>
                                                @error('phone_number')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mobile_number">Mobile Number <abbr title="Required">*</abbr></label>
                                                <input type="text" class="form-control" id="mobile_number" value="{{ old('mobile_number') }}" placeholder="Mobile Number" name="mobile_number" required>
                                                @error('mobile_number')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="locality">Locality</label>
                                                <select class="form-select form-select" data-placeholder="Choose" id="locality" name="locality">
                                                    <option value="">Choose...</option>
                                                    <option value="Local">Local</option>
                                                    <option value="Foreign">Foreign</option>
                                                </select>
                                                @error('locality')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="location_type">Location Type</label>
                                                <select class="form-select form-select" data-placeholder="Choose" id="location_type" name="location_type">
                                                    <option value="">Choose...</option>
                                                    <option value="Factory">Factory</option>
                                                    <option value="Warehouse">Warehouse</option>
                                                </select>
                                                @error('location_type')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="ntn_number">NTN Number <abbr title="Required">*</abbr></label>
                                                <input type="ntn_number" class="form-control" id="ntn_number" value="{{ old('ntn_number') }}" placeholder="NTN Number" name="ntn_number" required>
                                                @error('ntn_number')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card m-2 shadow border border-light rounded border-2">
                                    <div class="card-body">
                                        <h3 class="card-title">Upload relevant documents</h3>

                                        <div class="mb-3">
                                            <label for="secp_certificate">SECP Certificate</label>
                                            <input type="file" class="form-control" id="secp_certificate" name="secp_certificate" onchange="$('#CECPCertificate').show()">
                                            @error('secp_certificate')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="CECPCertificate" src="#" alt="SECP Certificate" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="iso_certificate">ISO Certificate</label>
                                            <input type="file" class="form-control" id="iso_certificate" name="iso_certificate" onchange="$('#ISOCertificate').show()">
                                            @error('iso_certificate')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="ISOCertificate" src="#" alt="ISO Certificate" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="commerce_membership">Commerce Membership</label>
                                            <input type="file" class="form-control" id="commerce_membership" name="commerce_membership" onchange="$('#CommerceMembership').show()">
                                            @error('commerce_membership')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="CommerceMembership" src="#" alt="Commerce Membership" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="pec_certificate">PEC Certificate</label>
                                            <input type="file" class="form-control" id="pec_certificate" name="pec_certificate" onchange="$('#PECCertificate').show()">
                                            @error('pec_certificate')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="PECCertificate" src="#" alt="PEC Certificate" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="annual_tax_returns">Annual Tax Returns</label>
                                            <input type="file" class="form-control" id="annual_tax_returns" name="annual_tax_returns" onchange="$('#AnnualTaxReturns').show()">
                                            @error('annual_tax_returns')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="AnnualTaxReturns" src="#" alt="Annual Tax Returns" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="audited_financial">Audited Financial</label>
                                            <input type="file" class="form-control" id="audited_financial" name="audited_financial" onchange="$('#AuditedFinancial').show()">
                                            @error('audited_financial')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="AuditedFinancial" src="#" alt="Audited Financial" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="dept_org_cert">Department / Organization Registrations</label>
                                            <input type="file" class="form-control" id="dept_org_cert" name="dept_org_cert" onchange="$('#DepartmentRegistrations').show()">
                                            @error('dept_org_cert')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="DepartmentRegistrations" src="#" alt="Department / Organization Registrations" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="performance_certificate">Performance Certificate</label>
                                            <input type="file" class="form-control" id="performance_certificate" name="performance_certificate" onchange="$('#PerformanceCertificate').show()">
                                            @error('performance_certificate')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="PerformanceCertificate" src="#" alt="Performance Certificate" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="form-actions">
                                            <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Apply</button>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push("script")
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            imageCropper({
                fileInput: "#secp_certificate",
                inputLabelPreview: "#CECPCertificate",
                aspectRatio: 1 / 1.6471
            });

            imageCropper({
                fileInput: "#iso_certificate",
                inputLabelPreview: "#ISOCertificate",
                aspectRatio: 1 / 1.6471
            });


            imageCropper({
                fileInput: '#commerce_membership',
                inputLabelPreview: '#CommerceMembership',
                aspectRatio: 1 / 1.6471
            });

            imageCropper({
                fileInput: '#pec_certificate',
                inputLabelPreview: '#PECCertificate',
                aspectRatio: 1 / 1.6471
            });

            imageCropper({
                fileInput: '#annual_tax_returns',
                inputLabelPreview: '#AnnualTaxReturns',
                aspectRatio: 1 / 1.6471
            });

            imageCropper({
                fileInput: '#audited_financial',
                inputLabelPreview: '#AuditedFinancial',
                aspectRatio: 1 / 1.6471
            });

            imageCropper({
                fileInput: '#dept_org_cert',
                inputLabelPreview: '#DepartmentRegistrations',
                aspectRatio: 1 / 1.6471
            });

            imageCropper({
                fileInput: '#performance_certificate',
                inputLabelPreview: '#PerformanceCertificate',
                aspectRatio: 1 / 1.6471
            });

            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            });

            $('#mobile_number').mask('0000-0000000', {
                placeholder: "____-_______"
            });

            $('#phone_number').mask('000-000000', {
                placeholder: "___-______"
            });

        });

    </script>
    @endpush
</x-main-layout>
