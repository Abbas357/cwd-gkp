<x-main-layout title="The consultant is {{ $consultant_registration->status === 'approved' ? 'Approved' : 'Not Approved' }}">
    <div class="container mt-2">
        <x-slot name="breadcrumbTitle">
            Consultant Details
        </x-slot>
    
        <x-slot name="breadcrumbItems">
            <li class="breadcrumb-item active">Consultant Profile</li>
        </x-slot>

        <div class="row consultant-details">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center no-print mb-4">
                    <h2></h2>
                    <button type="button" id="print-consultant" class="btn btn-light text-gray-900 border border-gray-300">
                        <span class="d-flex align-items-center">
                            <i class="bi-print"></i>
                            Print
                        </span>
                    </button>
                </div>

                <!-- Profile Image Section -->
                <div class="text-center mb-4">
                    <img src="{{ $consultant_registration->consultant->getFirstMediaUrl('consultant_pictures') }}" 
                         class="rounded-circle mb-3" 
                         alt="Consultant Profile"
                         style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #dee2e6;">
                    <h3>{{ $consultant_registration->consultant->firm_name }}</h3>
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
                                <td>{!! $consultant_registration->status === 'approved' ? '<span class="badge fs-6 bg-success">Approved</span>' : '<span class="badge fs-6 bg-danger">Not Approved</span>' !!}</td>
                            </tr>
                            
                            @if($consultant_registration->status === 'approved')
                            <tr>
                                <th>Issue Date</th>
                                <td>{{ $consultant_registration->updated_at->format('d-M-Y') }} ({{ $consultant_registration->updated_at->diffForHumans() }})</td>
                            </tr>
                            <tr>
                                <th>Expiration Date</th>
                                <td>{{ $consultant_registration->updated_at ->copy()->modify('+3 years')->format('d-M-Y') }} ({{ $consultant_registration->updated_at->copy()->modify('+3 years')->diffForHumans() }})</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $consultant_registration->consultant->name }}</td>
                            </tr>
                            <tr>
                                <th>Firm Name</th>
                                <td>{{ $consultant_registration->consultant->firm_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $consultant_registration->consultant->email }}</td>
                            </tr>
                            <tr>
                                <th>Mobile Number</th>
                                <td>{{ $consultant_registration->consultant->mobile_number }}</td>
                            </tr>
                            <tr>
                                <th>CNIC</th>
                                <td>{{ $consultant_registration->consultant->cnic }}</td>
                            </tr>
                            <tr>
                                <th>District</th>
                                <td>{{ $consultant_registration->consultant->district }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $consultant_registration->consultant->address }}</td>
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
                            @if($consultant_registration->status === 'approved')
                            <tr>
                                <th>PEC Number</th>
                                <td>{{ $consultant_registration->pec_number }}</td>
                            </tr>
                            <tr>
                                <th>Category Applied</th>
                                <td>{{ $consultant_registration->category_applied }}</td>
                            </tr>
                            <tr>
                                <th>PEC Category</th>
                                <td>{{ $consultant_registration->pec_category }}</td>
                            </tr>
                            <tr>
                                <th>FBR NTN</th>
                                <td>{{ $consultant_registration->fbr_ntn }}</td>
                            </tr>
                            <tr>
                                <th>KPRA Registration No</th>
                                <td>{{ $consultant_registration->kpra_reg_no }}</td>
                            </tr>
                            <tr>
                                <th>Pre Enlistments</th>
                                <td>
                                @php
                                    $preEnlistments = json_decode($consultant_registration->pre_enlistment, true);
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
                                <td>{{ $consultant_registration->is_limited }}</td>
                            </tr>
                            <tr>
                                <th>Documents</th>
                                <td>
                                    <ul class="list-group">
                                        <li class="list-group-item"><a href="{{ $consultant_registration->consultant->getFirstMediaUrl('consultant_cnic_front') }}">CNIC (Front)</a></li>
                                        <li class="list-group-item"><a href="{{ $consultant_registration->consultant->getFirstMediaUrl('consultant_cnic_back') }}">CNIC (Back)</a></li>
                                        <li class="list-group-item"><a href="{{ $consultant_registration->getFirstMediaUrl('fbr_attachments') }}">FBR Registration</a></li>
                                        <li class="list-group-item"><a href="{{ $consultant_registration->getFirstMediaUrl('kpra_attachments') }}">KPRA Certificate </a></li>
                                        <li class="list-group-item"><a href="{{ $consultant_registration->getFirstMediaUrl('pec_attachments') }}">PEC Certificate</a></li>
                                        <li class="list-group-item"><a href="{{ $consultant_registration->getFirstMediaUrl('form_h_attachments') }}">Form H</a></li>
                                        <li class="list-group-item"><a href="{{ $consultant_registration->getFirstMediaUrl('pre_enlistment_attachments') }}">Pre Enlistments</a></li>
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
                                        $humanResources = $consultant_registration->consultant->humanResources->where('status', 'approved');
                                    @endphp
                                    @foreach($humanResources as $hr)
                                    <tr>
                                        <td>{{ $hr->name }}</td>
                                        <td>{{ $hr->designation }}</td>
                                        <td>{{ $hr->pec_number }}</td>
                                        <td>{{ $hr->start_date ? date('d-M-Y', strtotime($hr->start_date)) : '-' }}</td>
                                        <td>
                                            @if($hr->getFirstMediaUrl('consultant_hr_resumes'))
                                            <a href="{{ $hr->getFirstMediaUrl('consultant_hr_resumes') }}" class="btn btn-sm btn-primary" target="_blank">
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
                                        $machinery = $consultant_registration->consultant->machinery->where('status', 'approved');
                                    @endphp
                                    @foreach($machinery as $machine)
                                    <tr>
                                        <td>{{ $machine->name }}</td>
                                        <td>{{ $machine->number }}</td>
                                        <td>{{ $machine->model }}</td>
                                        <td>{{ $machine->registration }}</td>
                                        <td>
                                            @if($machine->getMedia('consultant_machinery_docs'))
                                                @foreach($machine->getMedia('consultant_machinery_docs') as $index => $doc)
                                                <div class="mt-2 files">
                                                    <a href="{{ $doc->getUrl() }}" target="_blank" class="m-1 badge bg-primary">
                                                       Document {{ $index + 1 }}
                                                    </a>
                                                </div>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if($machine->getMedia('consultant_machinery_pics'))
                                                @foreach($machine->getMedia('consultant_machinery_pics') as $index => $doc)
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
                                        $workExperiences = $consultant_registration->consultant->workExperiences->where('status', 'approved');
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
                                            @if($experience->getFirstMediaUrl('consultant_work_orders'))
                                            <a href="{{ $experience->getFirstMediaUrl('consultant_work_orders') }}" class="btn btn-sm btn-primary" target="_blank">
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
            $('#print-consultant').on('click', () => {
                $(".consultant-details").printThis({
                    pageTitle: "Profile of {{ $consultant_registration->consultant->firm_name }}"
                });
            });
        </script>
        @endpush
    </div>
</x-main-layout>