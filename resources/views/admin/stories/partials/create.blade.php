<div class="row mx-1">
    <div class="col-md-8">
        <div class="col mb-4">
            <label for="name">Title</label>
            <input type="text" class="form-control" id="name" value="{{ old('title') }}" placeholder="Title" name="title" required>
            @error('title')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="col mb-4">
            <label for="image">Image</label>
            <input type="file" class="form-control" id="image" name="image" required>
            @error('image')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title pb-4">Image Preview</h3>
                <img src="#" class="d-none" id="preview-image" style="width:70%; border-radius: 10px" alt="Preview">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        imageCropper({
            fileInput: '#image'
            , inputLabelPreview: '#preview-image'
            , aspectRatio: 1 / 1.6471
            , onComplete() {
                $('#preview-image').removeClass('d-none');
            }
        });
    });

</script>
