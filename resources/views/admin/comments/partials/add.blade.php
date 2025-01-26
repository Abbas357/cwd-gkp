<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">

<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 mb-2">
                <label for="body">Body</label>
                <textarea name="body" id="body" class="form-control" style="height:200px">{{ old('body') }}</textarea>
            </div>
            <div class="col-md-12 mb-2">
                <label for="attachment">Attachment</label>
                <input type="file" class="form-control" id="attachment" name="attachment">
                <img id="previewAttachment" src="#" alt="Attachment Preview" style="display:none; margin-top: 10px; max-height: 100px;">
            </div>
            <input type="hidden" name="commentable_type" value="{{ $Comment->commentable_type }}">
            <input type="hidden" name="commentable_id" value="{{ $Comment->commentable_id }}">
            <input type="hidden" name="parent_id" value="{{ $Comment->id }}">
        </div>
    </div>
</div>

<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script>
    imageCropper({
        fileInput: "#attachment",
        inputLabelPreview: "#previewAttachment",
        aspectRatio: 1 / 1.6471,
        onComplete() {
            $("#previewAttachment").show();
        }
    });
</script>
