<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<div class="row mx-1">
    <div class="col-md-6 mb-3">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="File Name" name="title" required>
        @error('title')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="bps">BPS</label>
        <select class="form-select form-select-md" id="bps" name="bps">
            <option value="">Select Option</option>
            @foreach ($cat['bps'] as $bps)
            <option value="{{ $bps }}">{{ $bps }}</option>
            @endforeach
        </select>
        @error('bps')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="designation">Designation</label>
        <select class="form-select form-select-md" id="designation" name="designation">
            <option value="">Select Option</option>
            @foreach ($cat['designations'] as $designation)
            <option value="{{ $designation->name }}">{{ $designation->name }}</option>
            @endforeach
        </select>
        @error('designation')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="seniority_date">Seniority Date</label>
        <input type="date" class="form-control" id="seniority_date" name="seniority_date">
        @error('seniority_date')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-12 mb-3">
        <label for="attachment">Attachment</label>
        <input type="file" class="form-control" id="attachment" name="attachment" required>
        @error('attachment')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <img id="previewImage" src="#" alt="Preview Image" style="display:none; margin-top: 10px; max-height: 100px;">
    </div>
</div>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script>
    imageCropper({
        fileInput: "#attachment"
        , inputLabelPreview: "#previewImage"
        , aspectRatio: 2 / 3
        , onComplete() {
            $("#previewImage").show();
        }
    });
</script>
