<x-app-layout>
    <x-slot name="header">
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('registrations.index') }}">Registrations</a></li>
        <li class="breadcrumb-item active" aria-current="page">Show</li>
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4">Contractor Details</h2>
                <table class="table table-bordered">
                    <tr>
                        <th>Contractor Name</th>
                        <td>{{ $ContractorRegistration->contractor_name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $ContractorRegistration->email }}</td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td>{{ $ContractorRegistration->mobile_number }}</td>
                    </tr>
                    <tr>
                        <th>CNIC</th>
                        <td>{{ $ContractorRegistration->cnic }}</td>
                    </tr>
                    <tr>
                        <th>District</th>
                        <td>{{ $ContractorRegistration->district }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $ContractorRegistration->address }}</td>
                    </tr>
                    <tr>
                        <th>PEC Number</th>
                        <td>{{ $ContractorRegistration->pec_number }}</td>
                    </tr>
                    <tr>
                        <th>Owner Name</th>
                        <td>{{ $ContractorRegistration->owner_name }}</td>
                    </tr>
                    <tr>
                        <th>Category Applied</th>
                        <td>{{ $ContractorRegistration->category_applied }}</td>
                    </tr>
                    <tr>
                        <th>PEC Category</th>
                        <td>{{ $ContractorRegistration->pec_category }}</td>
                    </tr>
                    <tr>
                        <th>FBR NTN</th>
                        <td>{{ $ContractorRegistration->fbr_ntn }}</td>
                    </tr>
                    <tr>
                        <th>KPRA Registration No</th>
                        <td>{{ $ContractorRegistration->kpra_reg_no }}</td>
                    </tr>
                    <tr>
                        <th>Pre-Enlistment</th>
                        <td>{{ json_decode($ContractorRegistration->pre_enlistment, true) ? implode(', ', json_decode($ContractorRegistration->pre_enlistment, true)) : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Is Limited</th>
                        <td>{{ $ContractorRegistration->is_limited == 'yes' ? 'Yes' : 'No' }}</td>
                    </tr>
                    <tr>
                        <th>Defer Status</th>
                        <td>{{ $ContractorRegistration->defer_status }}</td>
                    </tr>
                    <tr>
                        <th>Approval Status</th>
                        <td>{{ $ContractorRegistration->status }}</td>
                    </tr>
                </table>

                <h3 class="mt-5">Uploaded Documents</h3>
                <div class="row mt-3">
                    @if($ContractorRegistration->cnic_front_attachment)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $ContractorRegistration->cnic_front_attachment) }}" class="card-img-top" alt="CNIC Front">
                                <div class="card-body">
                                    <p class="card-text">CNIC Front Side</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($ContractorRegistration->cnic_back_attachment)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $ContractorRegistration->cnic_back_attachment) }}" class="card-img-top" alt="CNIC Back">
                                <div class="card-body">
                                    <p class="card-text">CNIC Back Side</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($ContractorRegistration->fbr_attachment)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $ContractorRegistration->fbr_attachment) }}" class="card-img-top" alt="FBR Registration">
                                <div class="card-body">
                                    <p class="card-text">FBR Registration</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($ContractorRegistration->kpra_attachment)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $ContractorRegistration->kpra_attachment) }}" class="card-img-top" alt="KPRA Certificate">
                                <div class="card-body">
                                    <p class="card-text">KPRA Certificate</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($ContractorRegistration->pec_attachment)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $ContractorRegistration->pec_attachment) }}" class="card-img-top" alt="PEC Certificate">
                                <div class="card-body">
                                    <p class="card-text">PEC Certificate</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($ContractorRegistration->form_h_attachment)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $ContractorRegistration->form_h_attachment) }}" class="card-img-top" alt="Form H">
                                <div class="card-body">
                                    <p class="card-text">Form H</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($ContractorRegistration->pre_enlistment_attachment)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $ContractorRegistration->pre_enlistment_attachment) }}" class="card-img-top" alt="Previous Enlistment">
                                <div class="card-body">
                                    <p class="card-text">Previous Enlistment</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-4">
                    <a href="{{ route('registrations.index') }}" class="btn btn-primary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
