<x-main-layout title="The contractor is {{ $ContractorRegistration->status === 'approved' ? 'Approved' : 'Not Approved' }}">
    <div class="container mt-2">
        <x-slot name="breadcrumbTitle">
            Contractor Details
        </x-slot>
    
        <x-slot name="breadcrumbItems">
            <li class="breadcrumb-item active">Contractor Profile</li>
        </x-slot>

        <div class="row contractor-details">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center no-print mb-4">
                    <h2></h2>
                    <button type="button" id="print-contractor" class="btn btn-light text-gray-900 border border-gray-300">
                        <span class="d-flex align-items-center">
                            <i class="bi-print"></i>
                            Print
                        </span>
                    </button>
                </div>

                <!-- Profile Image Section -->
                <div class="text-center mb-4">
                    <img src="{{ $ContractorRegistration->contractor->getFirstMediaUrl('contractor_pictures') }}" 
                         class="rounded-circle mb-3" 
                         alt="Contractor Profile"
                         style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #dee2e6;">
                    <h3>{{ $ContractorRegistration->contractor->firm_name }}</h3>
                </div>

                <!-- Basic Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Basic Information</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200">Status</th>
                                <td>{!! $ContractorRegistration->status === 'approved' ? '<span class="badge fs-6 bg-success">Approved</span>' : '<span class="badge fs-6 bg-danger">Not Approved</span>' !!}</td>
                            </tr>
                            
                            @if($ContractorRegistration->status === 'approved')
                            <tr>
                                <th>Issue Date</th>
                                <td>{{ $ContractorRegistration->updated_at->format('d-M-Y') }} ({{ $ContractorRegistration->updated_at->diffForHumans() }})</td>
                            </tr>
                            <tr>
                                <th>Expiration Date</th>
                                <td>{{ $ContractorRegistration->updated_at ->copy()->modify('+3 years')->format('d-M-Y') }} ({{ $ContractorRegistration->updated_at->copy()->modify('+3 years')->diffForHumans() }})</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $ContractorRegistration->contractor->name }}</td>
                            </tr>
                            <tr>
                                <th>Firm Name</th>
                                <td>{{ $ContractorRegistration->contractor->firm_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $ContractorRegistration->contractor->email }}</td>
                            </tr>
                            <tr>
                                <th>Mobile Number</th>
                                <td>{{ $ContractorRegistration->contractor->mobile_number }}</td>
                            </tr>
                            <tr>
                                <th>CNIC</th>
                                <td>{{ $ContractorRegistration->contractor->cnic }}</td>
                            </tr>
                            <tr>
                                <th>District</th>
                                <td>{{ $ContractorRegistration->contractor->district }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $ContractorRegistration->contractor->address }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- Registration Information --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Registration Information</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">                           
                            @if($ContractorRegistration->status === 'approved')
                            <tr>
                                <th>PEC Number</th>
                                <td>{{ $ContractorRegistration->pec_number }}</td>
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
                                <th>Pre Enlistments</th>
                                <td>
                                @php
                                    $preEnlistments = json_decode($ContractorRegistration->pre_enlistment, true);
                                @endphp
                                @if(is_array($preEnlistments))
                                    <ul class="list-group">
                                        @foreach($preEnlistments as $enlistment)
                                            <li class="list-group-item">{{ $enlistment }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ $registration->pre_enlistment }}
                                @endif
                            </tr>
                            <tr>
                                <th>Limited Company</th>
                                <td>{{ $ContractorRegistration->is_limited }}</td>
                            </tr>
                            <tr>
                                <th>Documents</th>
                                <td>
                                    <ul class="list-group">
                                        <li class="list-group-item"><a href="{{ $ContractorRegistration->contractor->getFirstMediaUrl('contractor_cnic_front') }}">CNIC (Front)</a></li>
                                        <li class="list-group-item"><a href="{{ $ContractorRegistration->contractor->getFirstMediaUrl('contractor_cnic_back') }}">CNIC (Back)</a></li>
                                        <li class="list-group-item"><a href="{{ $ContractorRegistration->getFirstMediaUrl('fbr_attachments') }}">FBR Registration</a></li>
                                        <li class="list-group-item"><a href="{{ $ContractorRegistration->getFirstMediaUrl('kpra_attachments') }}">KPRA Certificate </a></li>
                                        <li class="list-group-item"><a href="{{ $ContractorRegistration->getFirstMediaUrl('pec_attachments') }}">PEC Certificate</a></li>
                                        <li class="list-group-item"><a href="{{ $ContractorRegistration->getFirstMediaUrl('form_h_attachments') }}">Form H</a></li>
                                        <li class="list-group-item"><a href="{{ $ContractorRegistration->getFirstMediaUrl('pre_enlistment_attachments') }}">Pre Enlistments</a></li>
                                    </ul>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <!-- Human Resources -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Human Resources</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>PEC Number</th>
                                        <th>Start Date</th>
                                        <th>Resume</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $humanResources = $ContractorRegistration->contractor->humanResources->where('status', 'approved');
                                    @endphp
                                    @foreach($humanResources as $hr)
                                    <tr>
                                        <td>{{ $hr->name }}</td>
                                        <td>{{ $hr->designation }}</td>
                                        <td>{{ $hr->pec_number }}</td>
                                        <td>{{ $hr->start_date ? date('d-M-Y', strtotime($hr->start_date)) : '-' }}</td>
                                        <td>
                                            @if($hr->getFirstMediaUrl('contractor_hr_resumes'))
                                            <a href="{{ $hr->getFirstMediaUrl('contractor_hr_resumes') }}" class="btn btn-sm btn-primary" target="_blank">
                                                <i class="bi-download"></i> Resume
                                            </a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Machinery -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Machinery</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Number</th>
                                        <th>Model</th>
                                        <th>Registration</th>
                                        <th>Documents</th>
                                        <th>Pictures</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $machinery = $ContractorRegistration->contractor->machinery->where('status', 'approved');
                                    @endphp
                                    @foreach($machinery as $machine)
                                    <tr>
                                        <td>{{ $machine->name }}</td>
                                        <td>{{ $machine->number }}</td>
                                        <td>{{ $machine->model }}</td>
                                        <td>{{ $machine->registration }}</td>
                                        <td>
                                            @if($machine->getMedia('contractor_machinery_docs'))
                                                @foreach($machine->getMedia('contractor_machinery_docs') as $index => $doc)
                                                <div class="mt-2 files">
                                                    <a href="{{ $doc->getUrl() }}" target="_blank" class="m-1 badge bg-primary">
                                                       Document {{ $index + 1 }}
                                                    </a>
                                                </div>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if($machine->getMedia('contractor_machinery_pics'))
                                                @foreach($machine->getMedia('contractor_machinery_pics') as $index => $doc)
                                                <div class="mt-2 files">
                                                    <a href="{{ $doc->getUrl() }}" target="_blank" class="m-1 badge bg-primary">
                                                       Picture {{ $index + 1 }}
                                                    </a>
                                                </div>
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Work Experience -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Work Experience</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>ADP Number</th>
                                        <th>Cost</th>
                                        <th>Status</th>
                                        <th>Duration</th>
                                        <th>Work Order</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $workExperiences = $ContractorRegistration->contractor->workExperiences->where('status', 'approved');
                                    @endphp
                                    @foreach($workExperiences as $experience)
                                    <tr>
                                        <td>{{ $experience->project_name }}</td>
                                        <td>{{ $experience->adp_number }}</td>
                                        <td>{{ number_format($experience->project_cost, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $experience->project_status === 'completed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($experience->project_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ date('M Y', strtotime($experience->commencement_date)) }} - 
                                            {{ $experience->completion_date ? date('M Y', strtotime($experience->completion_date)) : 'Ongoing' }}
                                        </td>
                                        <td>
                                            @if($experience->getFirstMediaUrl('contractor_work_orders'))
                                            <a href="{{ $experience->getFirstMediaUrl('contractor_work_orders') }}" class="btn btn-sm btn-primary" target="_blank">
                                                <i class="bi-file-earmark-text"></i> View
                                            </a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('script')
        <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
        <script>
            $('#print-contractor').on('click', () => {
                $(".contractor-details").printThis({
                    pageTitle: "Profile of {{ $ContractorRegistration->contractor->firm_name }}"
                });
            });
        </script>
        @endpush
    </div>
</x-main-layout>