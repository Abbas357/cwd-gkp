<x-main-layout>
    @push('style')
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush

    @include('site.consultants.partials.header')

    <div class="container">
        <form class="needs-validation" action="{{ route('consultants.hr.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card cw-shadow mb-4 rounded-0">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Employee Information <span class="ms-3 step-indicator">Step 2 of 3</span> <span class="ms-3 subtitle">After entering all Employees data click <a href="{{ route('consultants.projects.create') }}">here</a> to proceed and enter Projects details.</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label for="name">Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="eg. Name of Employee" name="name" required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="email">Email <abbr title="Required">*</abbr></label>
                            <input type="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Email" name="email" required>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="contact_number">Contact Number </label>
                            <input type="number" class="form-control" id="contact_number" value="{{ old('contact_number') }}" placeholder="Contact Number" name="contact_number">
                            @error('contact_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="cnic_number">CNIC Number </label>
                            <input type="text" class="form-control" id="cnic" value="{{ old('cnic_number') }}" placeholder="CNIC" name="cnic_number">
                            @error('cnic_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="pec_number">PEC Number (If any) <abbr title="Required">*</abbr></label>
                            <input type="number" class="form-control" id="pec_number" value="{{ old('pec_number') }}" placeholder="PEC Number" name="pec_number">
                            @error('pec_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="designation">Designation <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="designation" value="{{ old('designation') }}" placeholder="Designation" name="designation" required>
                            @error('designation')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="start_date">Start Date <abbr title="Required">*</abbr></label>
                            <input type="date" class="form-control" id="start_date" value="{{ old('start_date') }}" placeholder="Start Date" name="start_date" required>
                            @error('start_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="end_date">End Date <abbr title="Required">*</abbr></label>
                            <input type="date" class="form-control" id="end_date" value="{{ old('end_date') }}" placeholder="End Date" name="end_date" required>
                            @error('end_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="salary">Salary </label>
                            <input type="number" class="form-control" id="salary" value="{{ old('salary') }}" placeholder="Salary" name="salary">
                            @error('salary')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="my-2">
                <x-button type="submit" text="SAVE" />
            </div>
        </form>

        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-3 p-2"> List of Human Resources </h3>
                <table class="table p-5 table-stripped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>CNIC</th>
                            <th>PEC No.</th>
                            <th>Designation</th>
                            <th>Salary</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->contact_number }}</td>
                            <td>{{ $employee->cnic_number }}</td>
                            <td>{{ $employee?->pec_number ?? '-' }}</td>
                            <td>{{ $employee->designation }}</td>
                            <td>{{ number_format($employee->salary, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($employee->start_date)->format('j F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($employee->end_date)->format('j F Y') }}</td>
                            <td>
                                <span class="badge 
                                    @switch($employee->status)
                                        @case('draft') bg-secondary @break
                                        @case('rejected') bg-danger @break
                                        @case('approved') bg-success @break
                                        @default bg-light text-dark
                                    @endswitch">
                                    {{ ucfirst($employee->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center">No records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $employees->links() }}
        </div>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#cnic').mask('00000-0000000-0', {
                placeholder: "_____-_______-_"
            });

        });

    </script>
    @endpush
</x-main-layout>
