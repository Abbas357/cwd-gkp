<x-app-layout>
    <x-slot name="header">
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('standardizations.index') }}">Standardization</a></li>
        <li class="breadcrumb-item active" aria-current="page">Show</li>
    </x-slot>

    <div class="container mt-2">
        
        <div class="row standardization-details">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-4">Standardization Details</h2>
                    <button type="button" id="print-standardization" class="btn btn-light text-gray-900 border border-gray-300 float-end me-2 mb-2">
                        <span class="d-flex align-items-center">
                            <i class="bi-print"></i>
                            Print
                        </span>
                    </button>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Product Name</th>
                        <td>{{ $EStandardization->product_name }}</td>
                    </tr>
                    <tr>
                        <th>Specification Details</th>
                        <td>{{ $EStandardization->specification_details }}</td>
                    </tr>
                    <tr>
                        <th>Firm Name</th>
                        <td>{{ $EStandardization->firm_name }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $EStandardization->address }}</td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td>{{ $EStandardization->mobile_number }}</td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td>{{ $EStandardization->phone_number }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $EStandardization->email }}</td>
                    </tr>
                    <tr>
                        <th>NTN Number</th>
                        <td>{{ $EStandardization->ntn_number }}</td>
                    </tr>
                    <tr>
                        <th>Locality</th>
                        <td>{{ $EStandardization->locality }}</td>
                    </tr>
                    <tr>
                        <th>Location Type</th>
                        <td>{{ $EStandardization->location_type }}</td>
                    </tr>
                </table>

                <h3 class="mt-5">Uploaded Documents</h3>
                <div class="row mt-3">
                    @if($EStandardization->hasMedia('secp_certificates'))
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $EStandardization->getFirstMediaUrl('secp_certificates') }}" class="card-img-top" alt="SECP Certificate">
                            <div class="card-body">
                                <p class="card-text">SECP Certificate</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($EStandardization->hasMedia('iso_certificates'))
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $EStandardization->getFirstMediaUrl('iso_certificates') }}" class="card-img-top" alt="ISO Certificate">
                            <div class="card-body">
                                <p class="card-text">ISO Certificate</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($EStandardization->hasMedia('commerse_memberships'))
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $EStandardization->getFirstMediaUrl('commerse_memberships') }}" class="card-img-top" alt="Commerce Membership">
                            <div class="card-body">
                                <p class="card-text">Commerse Membership</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($EStandardization->hasMedia('pec_certificates'))
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $EStandardization->getFirstMediaUrl('pec_certificates') }}" class="card-img-top" alt="PEC Certificate">
                            <div class="card-body">
                                <p class="card-text">PEC Certificate</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($EStandardization->hasMedia('annual_tax_returns'))
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $EStandardization->getFirstMediaUrl('annual_tax_returns') }}" class="card-img-top" alt="Annual Tax Returns">
                            <div class="card-body">
                                <p class="card-text">Annual Tax Returns</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($EStandardization->hasMedia('audited_financials'))
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $EStandardization->getFirstMediaUrl('audited_financials') }}" class="card-img-top" alt="Audited Financial">
                            <div class="card-body">
                                <p class="card-text">Audited Financial</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($EStandardization->hasMedia('organization_registrations'))
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $EStandardization->getFirstMediaUrl('organization_registrations') }}" class="card-img-top" alt="Department / Organizations Certificate">
                            <div class="card-body">
                                <p class="card-text">Department / Organizations Certificate</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($EStandardization->hasMedia('performance_certificate'))
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $EStandardization->getFirstMediaUrl('performance_certificate') }}" class="card-img-top" alt="Performance Certificate">
                            <div class="card-body">
                                <p class="card-text">Performance Certificate</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @push('script')
        <script src="{{ asset('plugins/printThis/printThis.js') }}"></script>
        <script>
            $('#print-standardization').on('click', () => {
                $(".standardization-details").printThis({
                    pageTitle: "Standardization details of {{ $EStandardization->product_name }}"
                });
            });

        </script>
        @endpush
</x-app-layout>
