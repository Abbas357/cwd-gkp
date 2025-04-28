<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">

<div id="step-1" class="row">
    <div class="col-md-6 mb-3">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="Title" name="title" required>
        @error('title')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="load-users">User / Office</label>
        <select class="form-select form-select-md" id="load-users" name="user">
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="date_of_advertisement">Date of Advertisement</label>
        <input type="date" class="form-control" id="date_of_advertisement" value="{{ old('date_of_advertisement') }}" placeholder="Start Date & Time" name="date_of_advertisement" required>
        @error('date_of_advertisement')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="closing_date">Closing (Expiry) Date</label>
        <input type="date" class="form-control" id="closing_date" value="{{ old('closing_date') }}" placeholder="End Date & Time" name="closing_date" required>
        @error('closing_date')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-md-12 mb-3" id="step-2">
    <label for="description">Description</label>
    <div class="mb-3">
        <textarea name="description" id="description" class="form-control" style="height:120px">{{ old('description') }}</textarea>
    </div>
</div>

<div id="step-3" class="row">
    <div class="col-md-6 mb-3">
        <label for="tender_document">Tender Documents</label>
        <input type="file" class="form-control" id="tender_document" name="tender_documents[]" multiple required>
        @error('tender_document')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="bidding_document">Bidding Documents</label>
        <input type="file" class="form-control" id="bidding_document" name="bidding_documents[]" multiple>
        @error('bidding_document')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="tender_eoi_document">Tender / EOI Documents</label>
        <input type="file" class="form-control" id="tender_eoi_document" name="tender_eoi_documents[]" multiple>
        @error('tender_eoi_document')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#description').summernote({
            height: 180
        });

        select2Ajax(
            '#load-users',
            '{{ route("admin.apps.hr.users.api") }}',
            {
                placeholder: "Select User / Office",
                dropdownParent: $('#load-users').closest('.modal')
            }
        );

    });

</script>
