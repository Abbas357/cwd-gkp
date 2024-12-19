<x-app-layout title="Add Tender">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add Tender</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.tenders.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title pb-4">Add Tender</h3>
                                <a class="btn btn-success shadow-sm" href="{{ route('admin.tenders.index') }}">All Tenders</a>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="Title" name="title" required>
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="load-users">Office</label>
                                    <select class="form-select form-select-md" data-placeholder="Choose" id="load-users" name="user">
                                    </select>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="procurement_entity">Procurement Entity</label>
                                    <input type="text" class="form-control" id="procurement_entity" value="{{ old('procurement_entity') }}" placeholder="Procurement Entity" name="procurement_entity">
                                    @error('procurement_entity')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="description">Description</label>
                                    <div class="mb-3">
                                        <textarea name="description" id="description" class="form-control" style="height:150px">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date_of_advertisement">Date of Advertisement</label>
                                    <input type="date" class="form-control" id="date_of_advertisement" value="{{ old('date_of_advertisement') }}" placeholder="Start Date & Time" name="date_of_advertisement">
                                    @error('date_of_advertisement')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="closing_date">Closing (Expiry) Date</label>
                                    <input type="date" class="form-control" id="closing_date" value="{{ old('closing_date') }}" placeholder="End Date & Time" name="closing_date">
                                    @error('closing_date')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="tender_domain">Tender Domain</label>
                                    <select class="form-select form-select-md" id="tender_domain" name="tender_domain">
                                        <option value="">Select Option</option>
                                        @foreach ($cat['tender_domain'] as $tender_domain)
                                        <option value="{{ $tender_domain->name }}">{{ $tender_domain->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('tender_domain')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="tender_document">Tender Documents</label>
                                    <input type="file" class="form-control" id="tender_document" name="tender_documents[]" multiple>
                                    @error('tender_document')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="bidding_document">Bidding Documents</label>
                                    <input type="file" class="form-control" id="bidding_document" name="bidding_documents[]" multiple>
                                    @error('bidding_document')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="tender_eoi_document">Tender / EOI Documents</label>
                                    <input type="file" class="form-control" id="tender_eoi_document" name="tender_eoi_documents[]" multiple>
                                    @error('tender_eoi_document')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-actions mb-4 mt-2">
                                <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Add Tender</button>
                            </div>
                        </div>
                        <div class="col-md-4 d-none d-sm-block">
                            <div class="row g-5">
                                <div class="col-md-12 col-lg-12 order-md-last">
                                    <h4 class="mb-3">
                                        <span class="text-secondary">Statistics</span>
                                    </h4>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Total Tenders</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['totalCount'] }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Publish Tenders</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['publishedCount'] }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Unpublished Tenders</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['unPublishedCount'] }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Archived</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['archivedCount'] }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </form>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#description').summernote({
                height: 200
            , });

            $("#date_of_advertisement").flatpickr({
                enableTime: true
                , dateFormat: "Y-m-d H:i:S",
            });

            $("#closing_date").flatpickr({
                enableTime: true
                , dateFormat: "Y-m-d H:i:S"
            , });

            $('#load-users').select2({
                theme: "bootstrap-5"
                , dropdownParent: $('#load-users').parent()
                , ajax: {
                    url: '{{ route("admin.users.api") }}'
                    , dataType: 'json'
                    , data: function(params) {
                        return {
                            q: params.term
                            , page: params.page || 1
                        };
                    }
                    , processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items
                            , pagination: {
                                more: data.pagination.more
                            }
                        };
                    }
                    , cache: true
                }
                , minimumInputLength: 0
                , templateResult(user) {
                    return user.position;
                }
                , templateSelection(user) {
                    return user.position;
                }
            });

        });

    </script>
    @endpush
</x-app-layout>
