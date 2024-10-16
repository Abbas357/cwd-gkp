<x-guest-layout title="The registration is {{ $registration->status === 1 ? 'Approved' : 'Not Approved' }}">
    <div class="container mt-2">
        
        <div class="row standardization-details">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-4">Contractor Details</h2>
                    <button type="button" id="print-standardization" class="btn btn-light text-gray-900 border border-gray-300 float-end me-2 mb-2">
                        <span class="d-flex align-items-center">
                            <i class="bi-print"></i>
                            Print
                        </span>
                    </button>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Status</th>
                        <td>{!! $registration->status === 4 ? '<span class="badge fs-6 bg-success">Approved</span>' : '<span class="badge fs-6 bg-danger">Not Approved</span>' !!}</td>
                    </tr>
                    @if($registration->status === 4)
                    <tr>
                        <th>Issue Date</th>
                        <td>{{ $registration->updated_at->format('d-M-Y') }} ({{ $registration->updated_at->diffForHumans() }})</td>
                    </tr>
                    <tr>
                        <th>Expiration Date</th>
                        <td>{{ $registration->updated_at ->copy()->modify('+3 years')->format('d-M-Y') }} ({{ $registration->updated_at->copy()->modify('+3 years')->diffForHumans() }})</td>
                    </tr>
                    <tr>
                        <th>Contractor Name</th>
                        <td>{{ $registration->contractor_name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $registration->email }}</td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td>{{ $registration->mobile_number }}</td>
                    </tr>
                    <tr>
                        <th>CNIC</th>
                        <td>{{ $registration->cnic }}</td>
                    </tr>
                    <tr>
                        <th>District</th>
                        <td>{{ $registration->district }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $registration->address }}</td>
                    </tr>
                    <tr>
                        <th>PEC Number</th>
                        <td>{{ $registration->pec_number }}</td>
                    </tr>
                    <tr>
                        <th>Owner Name</th>
                        <td>{{ $registration->owner_name }}</td>
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
                        <th>FBR NTN</th>
                        <td>{{ $registration->fbr_ntn }}</td>
                    </tr>
                    <tr>
                        <th>KPRA Registration No</th>
                        <td>{{ $registration->kpra_reg_no }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
        @push('script')
        <script src="{{ asset('plugins/printThis/printThis.js') }}"></script>
        <script>
            $('#print-standardization').on('click', () => {
                $(".standardization-details").printThis({
                    pageTitle: "Standardization details of {{ $registration->registration_name }}"
                });
            });

        </script>
        @endpush
</x-guest-layout>
