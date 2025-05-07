<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<div class="row" id="step-1">
    <div class="col-md-6 mb-4">
        <label for="type">Gallery Type</label>
        <select class="form-select form-select-md" id="type" name="type" required>
            <option value="">Select Option</option>
            @foreach (category('gallery_type', 'main') as $type)
            <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>
        @error('type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-4">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="File Name" name="title" required>
        @error('title')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row" id="step-2">
    <div class="col-md-6 mb-4">
        <label for="cover_photo">Cover Photo</label>
        <input type="file" class="form-control" id="cover_photo" name="cover_photo">
        @error('cover_photo')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <img id="previewCover" src="#" alt="Preview Cover" style="display:none; margin-top: 10px; max-height: 100px;">
    </div>

    <div class="col-md-6 mb-4">
        <label for="images">Images</label>
        <input type="file" class="form-control" id="images" name="images[]" multiple required>
        @error('images')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row" id="step-3">
    <div class="col-md-12 mb-4">
        <label for="description">Description</label>
        <div class="mb-3">
            <textarea name="description" id="description" class="form-control" style="height:120px">{{ old('description') }}</textarea>
        </div>
    </div>
</div>

<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#description').summernote({
            height: 200
        , });

        imageCropper({
            fileInput: "#cover_photo"
            , inputLabelPreview: "#previewCover"
            , aspectRatio: 1 / 1
            , onComplete() {
                $("#previewCover").show();
            }
        });

        var forms = document.querySelectorAll('.needs-validation')

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
