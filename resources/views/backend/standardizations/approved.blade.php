<x-guest-layout title="The product is {{ $product->status === 1 ? 'Approved' : 'Not Approved' }}">
    <div class="container mt-2">
        
        <div class="row standardization-details">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-4">Product Details</h2>
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
                        <td>{!! $product->status === 1 ? '<span class="badge fs-6 bg-success">Approved</span>' : '<span class="badge fs-6 bg-danger">Not Approved</span>' !!}</td>
                    </tr>
                    @if($product->status === 1)
                    <tr>
                        <th>Issue Date</th>
                        <td>{{ $product->updated_at->format('d-M-Y') }} ({{ $product->updated_at->diffForHumans() }})</td>
                    </tr>
                    <tr>
                        <th>Expiration Date</th>
                        <td>{{ $product->updated_at ->copy()->modify('+3 years')->format('d-M-Y') }} ({{ $product->updated_at->copy()->modify('+3 years')->diffForHumans() }})</td>
                    </tr>
                    <tr>
                        <th>Product Name</th>
                        <td>{{ $product->product_name }}</td>
                    </tr>
                    <tr>
                        <th>Specification Details</th>
                        <td>{{ $product->specification_details }}</td>
                    </tr>
                    <tr>
                        <th>Firm Name</th>
                        <td>{{ $product->firm_name }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $product->address }}</td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td>{{ $product->mobile_number }}</td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td>{{ $product->phone_number }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $product->email }}</td>
                    </tr>
                    <tr>
                        <th>NTN Number</th>
                        <td>{{ $product->ntn_number }}</td>
                    </tr>
                    <tr>
                        <th>Locality</th>
                        <td>{{ $product->locality }}</td>
                    </tr>
                    <tr>
                        <th>Location Type</th>
                        <td>{{ $product->location_type }}</td>
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
                    pageTitle: "Standardization details of {{ $product->product_name }}"
                });
            });

        </script>
        @endpush
</x-guest-layout>
