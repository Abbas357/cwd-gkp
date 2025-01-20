<x-main-layout>
    @push('style')
    <style>
        .warning-label {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .border-danger {
            border-color: #dc3545 !important;
        }

        .border-danger:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
        }

    </style>
    @endpush
    @include('site.standardizations.partials.header')

    <div class="container">
        
        <div id="pec-validation-message" class="alert alert-dismissible fade" role="alert" style="display: none;">
            <span id="pec-message-text"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <form class="needs-validation" class="registration-form" action="{{ route('standardizations.product.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card mb-4">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Product Details
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label for="product_name">Product Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="product_name" value="{{ old('product_name') }}" placeholder="Product Name" name="product_name" required>
                            @error('product_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="col-md-4">
                            <label for="locality">Locality</label>
                            <select class="form-select" data-placeholder="Choose" id="locality" name="locality">
                                <option value="">Choose...</option>
                                <option value="Local">Local</option>
                                <option value="Foreign">Foreign</option>
                            </select>
                            @error('locality')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="col-md-4">
                            <label for="location_type">Location Type</label>
                            <select class="form-select" data-placeholder="Choose" id="location_type" name="location_type">
                                <option value="">Choose...</option>
                                <option value="Factory">Factory</option>
                                <option value="Warehouse">Warehouse</option>
                                <option value="Store">Store</option>
                                <option value="Distribution Center">Distribution Center</option>
                            </select>
                            @error('location_type')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="col-md-2">
                            <label for="ntn_number">NTN Number <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="ntn_number" value="{{ old('ntn_number') }}" placeholder="NTN Number" name="ntn_number" required>
                            @error('ntn_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <label for="sale_tax_number">Sale Tax Number <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="sale_tax_number" value="{{ old('sale_tax_number') }}" placeholder="NTN Number" name="sale_tax_number" required>
                            @error('sale_tax_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <div class="col-md-8">
                            <label for="specification_details">Specification Details <abbr title="Required">*</abbr></label>
                            <textarea name="specification_details" id="specification_details" class="form-control w-100" style="min-height:150px"></textarea>
                            @error('specification_details')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Attachments
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="product_images">Product Images</label>
                            <input type="file" class="form-control" id="product_images" name="product_images[]" multiple required>
                            @error('product_images')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions mt-4">
                <x-button type="submit" text="Submit" id="submitBtn" />
            </div>
        </form>
    </div>
</x-main-layout>
