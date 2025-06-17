<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">

<div id="step-1" class="row">

    <div class="col-md-6 mb-3">
        <label for="document_type">Document Type</label>
        <select class="form-select form-select-md" id="document_type" name="document_type" required>
            <option value="">Select Option</option>
            @foreach ($cat['document_type'] as $document_type)
            <option value="{{ $document_type }}">{{ $document_type }}</option>
            @endforeach
        </select>
        @error('document_type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="Title" name="title" required>
        @error('title')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="document_number">Document Number</label>
        <input type="text" class="form-control" id="document_number" value="{{ old('document_number') }}" placeholder="Document Number" name="document_number">
        @error('document_number')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="issue_date">Issue Date</label>
        <input type="date" class="form-control" id="issue_date" value="{{ old('issue_date') }}" placeholder="Issued Date" name="issue_date">
        @error('issue_date')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-md-12 mb-3" id="step-2">
    <label for="description">Description</label>
    <div class="mb-3">
        <textarea name="description" id="description" class="form-control" style="height:100px">{{ old('description') }}</textarea>
    </div>
    <div class="col-md-12 mb-3">
        <label for="attachment">Attachments</label>
        <input type="file" class="form-control" id="attachment" name="attachment">
        @error('attachment')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        imageCropper({
            fileInput: '#attachment'
            , inputLabelPreview: '#preview-attachment'
            , aspectRatio: 2 / 3
        });
    });
</script>