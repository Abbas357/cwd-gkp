<x-main-layout title="The product is {{ $Standardization->status === 'approved' ? 'Approved' : 'Not Approved' }}">
    <div class="container mt-2">
        <x-slot name="breadcrumbTitle">
            Product Details
        </x-slot>

        <x-slot name="breadcrumbItems">
            <li class="breadcrumb-item active">Product Card</li>
        </x-slot>
        <div class="row standardization-details">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center no-print">
                    <h2 class="mb-4"></h2>
                    <button type="button" id="print-standardization" class="cw-btn m-3">
                        <span class="d-flex align-items-center">
                            <i class="bi-print"></i>
                            Print
                        </span>
                    </button>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Status</th>
                        <td>{!! $Standardization->status === 'approved' ? '<span class="badge fs-6 bg-success">Approved</span>' : '<span class="badge fs-6 bg-danger">Not Approved</span>' !!}</td>
                    </tr>
                    @if($Standardization->status === 'approved')
                    <tr>
                        <th>Issue Date</th>
                        <td>{{ $Standardization->updated_at->format('d-M-Y') }} ({{ $Standardization->updated_at->diffForHumans() }})</td>
                    </tr>
                    <tr>
                        <th>Expiration Date</th>
                        <td>{{ $Standardization->updated_at ->copy()->modify('+3 years')->format('d-M-Y') }} ({{ $Standardization->updated_at->copy()->modify('+3 years')->diffForHumans() }})</td>
                    </tr>
                    <tr>
                        <th>Firm Name</th>
                        <td>{{ $Standardization->firm_name }}</td>
                    </tr>
                    @endif
                </table>
            </div>

            <div>
                <div class="card-title mt-4">
                    <h2>Approved Products</h2>
                </div>

                <div class="card-body">
                    <div class="table-responsive" style="min-height: 200px">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Locality</th>
                                    <th>Location Type</th>
                                    <th>NTN Number</th>
                                    <th>Sale Tax Number</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->locality }}</td>
                                    <td>{{ ucfirst($product->location_type) }}</td>
                                    <td>{{ $product->ntn_number }}</td>
                                    <td>{{ $product->sale_tax_number }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $product->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">No products found</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        @push('script')
        <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
        <script>
            $('#print-standardization').on('click', () => {
                $(".standardization-details").printThis({
                    pageTitle: "Standardization details of {{ $Standardization->product_name }}"
                });
            });

        </script>
        @endpush
</x-main-layout>
