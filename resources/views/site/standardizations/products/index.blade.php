<x-main-layout>
    @push('style')
    <style>
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status-new { background: #3094f8; color: #fff; }
        .status-rejected { background: #ff2d08; color: #fff; }
        .status-approved { background: #11af19; color: #fff; }
        
        .custom-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .custom-dropdown-menu {
            position: absolute;
            z-index: 9999;
            display: none;
            min-width: 160px;
            padding: 0.5rem 0;
            background-color: #fff;
            border: 1px solid rgba(0,0,0,.15);
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175);
            right: 0;
        }
        
        .custom-dropdown-menu.show {
            display: block;
        }
        
        .custom-dropdown-item {
            display: block;
            width: 100%;
            padding: 0.5rem 1rem;
            clear: both;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
            color: #212529;
            text-decoration: none;
        }
        
        .custom-dropdown-item:hover {
            background-color: #f8f9fa;
            color: #16181b;
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
        
        .document-title {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
        }
        </style>
    @endpush
    @include('site.standardizations.partials.header')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-0">standardization Registrations</h4>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('standardizations.product.create') }}" class="btn btn-primary">
                            New Product
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive" style="min-height: 200px">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>S.#</th>
                                <th>Product Name</th>
                                <th>Locality</th>
                                <th>Location Type</th>
                                <th>NTN Number</th>
                                <th>Sale Tax Number</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->locality }}</td>
                                    <td>{{ ucfirst($product->location_type) }}</td>
                                    <td>{{ $product->ntn_number }}</td>
                                    <td>{{ $product->sale_tax_number }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $product->status }}">
                                            {{ str_replace('_', ' ', ucfirst($product->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a class="cw-btn" href="{{ route('standardizations.product.show', $product->id) }}">
                                            <i class="bi-eye"></i>
                                        </a>
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
            
                <div class="mt-4">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
            
        </div>
    </div>
</x-main-layout>