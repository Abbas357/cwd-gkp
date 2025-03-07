<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<div class="row mx-1" id="step-1">
    <div class="col-md-12 mb-3">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="Slider title" name="title" required>
        @error('title')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="summary">Short Description</label>
        <div class="mb-3">
            <textarea name="summary" id="summary" class="form-control" style="height:80px">{{ old('summary') }}</textarea>
        </div>
    </div>
</div>
<div class="row mx-1" id="step-2">
    <div class="col-md-12 mb-3">
        <label for="image">Image</label>
        <input type="file" class="form-control" id="image" name="image" required>
        @error('image')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-12 mb-3">
        <label for="description">Content</label>
        <div class="mb-3">
            <textarea name="description" id="description" class="form-control" style="height:150px">{{ old('description') }}</textarea>
        </div>
    </div>
</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#description').summernote({
            height: 200
        , });

        imageCropper({
            fileInput: "#image"
            , inputLabelPreview: "#previewSlider"
            , aspectRatio: 16 / 9
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
