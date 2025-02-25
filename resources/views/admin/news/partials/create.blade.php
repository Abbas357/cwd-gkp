<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<div class="row mx-1">
    <div class="col-md-4 mb-3">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="News title" name="title" required>
        @error('title')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="news_category">Category</label>
        <select class="form-select form-select-md" id="news_category" name="news_category" required>
            <option value="">Select Option</option>
            @foreach ($cat['news_category'] as $type)
            <option value="{{ $type->name }}">{{ $type->name }}</option>
            @endforeach
        </select>
        @error('news_category')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="attachment">Attachment</label>
        <input type="file" class="form-control" id="attachment" name="attachment" required>
        @error('attachment')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="summary">Short Description</label>
        <textarea name="summary" id="summary" class="form-control" style="height: 70px">{{ old('summary') }}</textarea>
    </div>

    <div class="col-md-12 mb-3">
        <label for="content">Description</label>
        <div class="mb-3">
            <textarea name="content" id="content" class="form-control" style="height:150px">{{ old('content') }}</textarea>
        </div>
    </div>
</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#content').summernote({
            height: 200
        , });

        imageCropper({
            fileInput: "#attachment"
            , inputLabelPreview: "#previewNews"
            , aspectRatio: 4 / 3
        });

        var forms = document.querySelectorAll('.needs-validation');

        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        });

    });

</script>