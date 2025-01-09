<x-main-layout title="The contractor is {{ $contractor->status === 'approved' ? 'Approved' : 'Not Approved' }}">
    <div class="container mt-2">
        <x-slot name="breadcrumbTitle">
            Contractor Details
        </x-slot>
    
        <x-slot name="breadcrumbItems">
            <li class="breadcrumb-item active">Contractor Card</li>
        </x-slot>
        <div class="row contractor-details">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center no-print">
                    <h2 class="mb-4"></h2>
                    <button type="button" id="print-contractor" class="btn btn-light text-gray-900 border border-gray-300 float-end me-2 mb-2">
                        <span class="d-flex align-items-center">
                            <i class="bi-print"></i>
                            Print
                        </span>
                    </button>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Status</th>
                        <td>{!! $contractor->status === 'approved' ? '<span class="badge fs-6 bg-success">Approved</span>' : '<span class="badge fs-6 bg-danger">Not Approved</span>' !!}</td>
                    </tr>
                    @if($contractor->status === 'approved')
                    <tr>
                        <th>Issue Date</th>
                        <td>{{ $contractor->updated_at->format('d-M-Y') }} ({{ $contractor->updated_at->diffForHumans() }})</td>
                    </tr>
                    <tr>
                        <th>Expiration Date</th>
                        <td>{{ $contractor->updated_at ->copy()->modify('+3 years')->format('d-M-Y') }} ({{ $contractor->updated_at->copy()->modify('+3 years')->diffForHumans() }})</td>
                    </tr>
                    <tr>
                        <th>Contractor Name</th>
                        <td>{{ $contractor->contractor_name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $contractor->email }}</td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td>{{ $contractor->mobile_number }}</td>
                    </tr>
                    <tr>
                        <th>CNIC</th>
                        <td>{{ $contractor->cnic }}</td>
                    </tr>
                    <tr>
                        <th>District</th>
                        <td>{{ $contractor->district }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $contractor->address }}</td>
                    </tr>
                    <tr>
                        <th>PEC Number</th>
                        <td>{{ $contractor->pec_number }}</td>
                    </tr>
                    <tr>
                        <th>Owner Name</th>
                        <td>{{ $contractor->owner_name }}</td>
                    </tr>
                    <tr>
                        <th>Category Applied</th>
                        <td>{{ $contractor->category_applied }}</td>
                    </tr>
                    <tr>
                        <th>PEC Category</th>
                        <td>{{ $contractor->pec_category }}</td>
                    </tr>
                    <tr>
                        <th>FBR NTN</th>
                        <td>{{ $contractor->fbr_ntn }}</td>
                    </tr>
                    <tr>
                        <th>KPRA Registration No</th>
                        <td>{{ $contractor->kpra_reg_no }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
        @push('script')
        <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
        <script>
            $('#print-contractor').on('click', () => {
                $(".contractor-details").printThis({
                    pageTitle: "Details of {{ $contractor->contractor_name }}"
                });
            });

        </script>
        @endpush
</x-main-layout>
