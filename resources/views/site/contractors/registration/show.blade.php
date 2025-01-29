<x-main-layout>
    @push('style')
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            .print-break-after {
                page-break-after: always;
            }
            .document-preview {
                break-inside: avoid;
            }
        }
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status-draft { background: #e3f2fd; color: #1976d2; }
        .status-deferred_one { background: #fff3e0; color: #f57c00; }
        .status-deferred_two { background: #fbe9e7; color: #d84315; }
        .status-deferred_three { background: #ffebee; color: #c62828; }
        .status-approved { background: #e8f5e9; color: #2e7d32; }
        
        .document-preview {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .document-preview img {
            max-width: 100%;
            height: auto;
            margin-top: 0.5rem;
        }
        .badge-lg {
            font-size: 1.2rem;
            padding: 0.5em 1em;
        }
    </style>
    @endpush
    @include('site.contractors.partials.header')
    <div class="container my-4">
        <div class="card" id="contractor-detail">
            <div class="card-header bg-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-0">Registration Details</h4>
                    </div>
                    <div class="col-auto no-print">
                        <button class="cw-btn" id="print-detail">
                            <i class="fas fa-print me-2"></i>Print
                        </button>
                        <a href="{{ route('contractors.registration.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Registration Information -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Name</th>
                                        <td>{{ $registration->contractor->name }}</td>
                                    </tr>
                                    <tr>
                                        <th width="40%">Firm Name</th>
                                        <td>{{ $registration->contractor->firm_name }}</td>
                                    </tr>
                                    <tr>
                                        <th width="40%">Email</th>
                                        <td>{{ $registration->contractor->email }}</td>
                                    </tr>
                                    <tr>
                                        <th width="40%">Mobile Number</th>
                                        <td>{{ $registration->contractor->mobile_number }}</td>
                                    </tr>
                                    <tr>
                                        <th width="40%">District</th>
                                        <td>{{ $registration->contractor->district }}</td>
                                    </tr>
                                    <tr>
                                        <th width="40%">Address</th>
                                        <td>{{ $registration->contractor->address }}</td>
                                    </tr>
                                    <tr>
                                        <th width="40%">CNIC</th>
                                        <td>{{ $registration->contractor->cnic }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge badge-lg
                                                @switch($registration->status)
                                                    @case('draft')
                                                        bg-primary
                                                        @break
                                                    @case('deferred_once')
                                                        bg-warning
                                                        @break
                                                    @case('deferred_twice')
                                                        text-white" style="background-color: darkorange
                                                        @break
                                                    @case('deferred_thrice')
                                                        bg-danger
                                                        @break
                                                    @case('approved')
                                                        bg-success
                                                        @break
                                                    @default
                                                        bg-secondary
                                                @endswitch
                                            ">
                                                {{ str_replace('_', ' ', ucfirst($registration->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Registration Details</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">PEC Number</th>
                                        <td>{{ $registration->pec_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category Applied</th>
                                        <td>{{ $registration->category_applied }}</td>
                                    </tr>
                                    <tr>
                                        <th>PEC Category</th>
                                        <td>{{ $registration->pec_category }}</td>
                                    </tr>
                                    <tr>
                                        <th width="40%">FBR NTN</th>
                                        <td>{{ $registration->fbr_ntn }}</td>
                                    </tr>
                                    <tr>
                                        <th>KPRA Reg No</th>
                                        <td>{{ $registration->kpra_reg_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Limited Company</th>
                                        <td>{{ $registration->is_limited ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Previous Enlistments</th>
                                        <td>
                                            @php
                                                $preEnlistments = json_decode($registration->pre_enlistment, true);
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
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Applied Date</th>
                                        <td>{{ $registration->created_at->format('M d, Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Section -->
                    <div class="col-12 print-break-after">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Submitted Documents</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    @foreach($documents as $title => $document)
                                        @if($document['url'])
                                            <div class="col-md-3">
                                                <div class="document-preview">
                                                    <h6 class="mb-3">{{ $title }}</h6>
                                                    <div class="border rounded p-2">
                                                        @if(Str::startsWith($document['mime_type'], 'image/'))
                                                            <img src="{{ $document['url'] }}" alt="{{ $title }}" style="height:400px; width:300px" class="img-fluid">
                                                        @else
                                                            <div class="text-center p-3 bg-light">
                                                                <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                                                <p class="mt-2 mb-0">{{ $title }}</p>
                                                            </div>
                                                        @endif
                                                        <div class="mt-2 no-print">
                                                            <a href="{{ $document['url'] }}" class="btn btn-sm btn-primary" target="_blank">
                                                                View Document
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('site/lib/printThis/printThis.min.js') }}"></script>
    <script>
        
        $('#print-detail').on('click', () => {
            $("#contractor-detail").printThis({
                pageTitle: "Registration Details"
            });
        });

    </script>
    @endpush
</x-main-layout>