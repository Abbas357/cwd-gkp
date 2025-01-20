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

        .status-new {
            background: #e3f2fd;
            color: #1976d2;
        }

        .status-rejected {
            background: #fff3e0;
            color: #f57c00;
        }

        .status-approved {
            background: #e8f5e9;
            color: #2e7d32;
        }

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
    @include('site.standardizations.partials.header')
    <div class="container my-4">
        <div class="card">
            <div class="card-header bg-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-0">Registration Details</h4>
                    </div>
                    <div class="col-auto no-print">
                        <button class="cw-btn" id="print-btn">
                            <i class="fas fa-print me-2"></i>Print
                        </button>
                        <a href="{{ route('standardizations.product.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body" id="product-details">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Product Name</th>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th>Locality</th>
                            <td>{{ $product->locality }}</td>
                        </tr>
                        <tr>
                            <th>Location Type</th>
                            <td>{{ $product->location_type }}</td>
                        </tr>
                        <tr>
                            <th>NTN Number</th>
                            <td>{{ $product->ntn_number }}</td>
                        </tr>
                        <tr>
                            <th>Sales Tax Number</th>
                            <td>{{ $product->sale_tax_number }}</td>
                        </tr>
                        <tr>
                            <th>Specification Details</th>
                            <td>{{ $product->specification_details }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge badge-lg
                                    @switch($product->status)
                                        @case('new')
                                            bg-primary
                                            @break
                                        @case('rejected')
                                            bg-danger
                                            @break
                                        @case('approved')
                                            bg-success
                                            @break
                                        @default
                                            bg-secondary
                                    @endswitch
                                ">
                                    {{ str_replace('_', ' ', ucfirst($product->status)) }}
                                </span>
                            </td>
                        </tr>
                        @if($product->remarks)
                        <tr>
                            <th>Remarks</th>
                            <td>
                                {{ $product->remarks }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                <h4 class="mt-4">Product Images</h4>
                <div class="row">
                    @foreach($images as $image)
                    <div class="col-md-5 mb-3">
                        <img src="{{ $image->getUrl() }}" class="img-fluid img-thumbnail" alt="Product Image">
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('standardizations.product.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>

    </div>
    @push('script')
    <script src="{{ asset('site/lib/printThis/printThis.min.js') }}"></script>
    <script>
        $('#print-btn').on('click', () => {
            $("#product-details").printThis({
                pageTitle: "Product Details"
            });
        });

    </script>
    @endpush
</x-main-layout>
