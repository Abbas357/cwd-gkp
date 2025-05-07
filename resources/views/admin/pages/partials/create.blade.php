<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<div class="row" id="step-1">
    <div class="col-md-6 mb-4">
        <label for="page_type">Page Type</label>
        <select class="form-select form-select-md" id="page_type" name="page_type" required>
            <option value="">Select Option</option>
            @foreach (category('page_type', 'main') as $type)
            <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>
        @error('page_type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="title">Page Title</label>
        <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="Page title" name="title" required>
        @error('title')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="attachments">Attachments</label>
        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
        @error('attachments')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row" id="step-2">
    <div class="col-md-12 mb-3">
        <label for="content">Content</label>
        <div class="mb-3">
            <textarea name="content" id="content" class="form-control">{{ old('content') }}</textarea>
        </div>
    </div>
</div>

<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#content').summernote({
            height: 200
        , });
        
    })

</script>
