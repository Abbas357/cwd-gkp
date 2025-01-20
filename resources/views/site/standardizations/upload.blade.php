<x-main-layout>
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    <style>
        .warning-label {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .border-danger {
            border-color: #dc3545 !important;
        }

        .border-danger:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
        }

    </style>
    @endpush
    @include('site.standardizations.partials.header')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Upload Documents</h2>
        </div>
        <form action="{{ route('standardizations.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="card mb-4">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Following documents are required for standardization of your firm
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label for="secp_certificate">SECP Certificate</label>
                            @if($standardization->hasMedia('secp_certificates'))
                                <i class="bi-check-circle-fill text-success"></i> <a target="_blank" href="{{ $standardization->getFirstMediaUrl('secp_certificates') }}">View Current</a>
                            @endif
                            <input type="file" class="form-control" id="secp_certificate" name="secp_certificate">
                            @error('secp_certificate')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="CECPCertificate" src="#" alt="SECP Certificate" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="iso_certificate">ISO Certificate</label>
                            @if($standardization->hasMedia('iso_certificates'))
                            <i class="bi-check-circle-fill text-success"></i> <a target="_blank" href="{{ $standardization->getFirstMediaUrl('iso_certificates') }}">View Current</a>
                            @endif
                            <input type="file" class="form-control" id="iso_certificate" name="iso_certificate">
                            @error('iso_certificate')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="ISOCertificate" src="#" alt="ISO Certificate" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="commerce_membership">Commerce Membership</label>
                            @if($standardization->hasMedia('commerse_memberships'))
                                <i class="bi-check-circle-fill text-success"></i> <a target="_blank" href="{{ $standardization->getFirstMediaUrl('commerse_memberships') }}">View Current</a>
                            @endif
                            <input type="file" class="form-control" id="commerce_membership" name="commerce_membership">
                            @error('commerce_membership')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="CommerceMembership" src="#" alt="Commerce Membership" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="pec_certificate">PEC Certificate</label>
                            @if($standardization->hasMedia('pec_certificates'))
                                <i class="bi-check-circle-fill text-success"></i> <a target="_blank" href="{{ $standardization->getFirstMediaUrl('pec_certificates') }}">View Current</a>
                            @endif
                            <input type="file" class="form-control" id="pec_certificate" name="pec_certificate">
                            @error('pec_certificate')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="PECCertificate" src="#" alt="PEC Certificate" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="annual_tax_returns">Annual Tax Returns</label>
                            @if($standardization->hasMedia('annual_tax_returns'))
                                <i class="bi-check-circle-fill text-success"></i> <a target="_blank" href="{{ $standardization->getFirstMediaUrl('annual_tax_returns') }}">View Current</a>
                            @endif
                            <input type="file" class="form-control" id="annual_tax_returns" name="annual_tax_returns">
                            @error('annual_tax_returns')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="AnnualTaxReturns" src="#" alt="Annual Tax Returns" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="audited_financial">Audited Financial</label>
                            @if($standardization->hasMedia('audited_financials'))
                                <i class="bi-check-circle-fill text-success"></i> <a target="_blank" href="{{ $standardization->getFirstMediaUrl('audited_financials') }}">View Current</a>
                            @endif
                            <input type="file" class="form-control" id="audited_financial" name="audited_financial">
                            @error('audited_financial')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="AuditedFinancial" src="#" alt="Audited Financial" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="dept_org_cert">Department / Organization Registrations</label>
                            @if($standardization->hasMedia('organization_registrations'))
                                <i class="bi-check-circle-fill text-success"></i> <i class="bi-check-circle-fill text-success"></i> <a target="_blank" href="{{ $standardization->getFirstMediaUrl('organization_registrations') }}">View Current</a>
                            @endif
                            <input type="file" class="form-control" id="dept_org_cert" name="dept_org_cert">
                            @error('dept_org_cert')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="DepartmentRegistrations" src="#" alt="Department / Organization Registrations" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="performance_certificate">Performance Certificate</label>
                            @if($standardization->hasMedia('performance_certificate'))
                                <i class="bi-check-circle-fill text-success"></i> <a target="_blank" href="{{ $standardization->getFirstMediaUrl('performance_certificate') }}">View Current</a>
                            @endif
                            <input type="file" class="form-control" id="performance_certificate" name="performance_certificate">
                            @error('performance_certificate')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="PerformanceCertificate" src="#" alt="Performance Certificate" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('standardizations.dashboard') }}" class="btn btn-light me-2">Cancel</a>
                <x-button type="submit" text="Update Documents" />
            </div>
        </form>
    </div>
    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            imageCropper({
                fileInput: "#secp_certificate"
                , inputLabelPreview: "#CECPCertificate"
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $("#CECPCertificate").show();
                }
            });

            imageCropper({
                fileInput: "#iso_certificate"
                , inputLabelPreview: "#ISOCertificate"
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $("#ISOCertificate").show();
                }
            });


            imageCropper({
                fileInput: '#commerce_membership'
                , inputLabelPreview: '#CommerceMembership'
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $("#CommerceMembership").show();
                }
            });

            imageCropper({
                fileInput: '#pec_certificate'
                , inputLabelPreview: '#PECCertificate'
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $("#PECCertificate").show();
                }
            });

            imageCropper({
                fileInput: '#annual_tax_returns'
                , inputLabelPreview: '#AnnualTaxReturns'
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $("#AnnualTaxReturns").show();
                }
            });

            imageCropper({
                fileInput: '#audited_financial'
                , inputLabelPreview: '#AuditedFinancial'
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $("#AuditedFinancial").show();
                }
            });

            imageCropper({
                fileInput: '#dept_org_cert'
                , inputLabelPreview: '#DepartmentRegistrations'
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $("#DepartmentRegistrations").show();
                }
            });

            imageCropper({
                fileInput: '#performance_certificate'
                , inputLabelPreview: '#PerformanceCertificate'
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $("#PerformanceCertificate").show();
                }
            });

        });

    </script>
    @endpush
</x-main-layout>
