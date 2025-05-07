<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">

<div class="row" id="step-1">
    <div class="col-md-6 mb-3">
        <label for="file_name">File Name</label>
        <input type="text" class="form-control" id="file_name" value="{{ old('file_name') }}" placeholder="File Name" name="file_name" required>
        @error('file_name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="file_type">File Type</label>
        <select class="form-select form-select-md" id="file_type" name="file_type" required>
            <option value="">Select Option</option>
            @foreach ($cat['file_type'] as $file_type)
            <option value="{{ $file_type }}">{{ $file_type }}</option>
            @endforeach
        </select>
        @error('file_type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="project_id">Project</label>
        <select class="form-select form-select-md" id="project_id" name="project_id" required>
            <option value="">Select Option</option>
            @foreach ($cat['projects'] as $project)
            <option value="{{ $project->id }}">{{ $project->name }}</option>
            @endforeach
        </select>
        @error('project_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row" id="step-2">
    <div class="col-md-5 mb-3">
        <label for="file_link">File Link</label>
        <input type="text" class="form-control" id="file_link" value="{{ old('file_link') }}" placeholder="File Name" name="file_link">
        @error('file_link')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-2 d-flex align-items-center justify-content-center">
        <span class="badge bg-secondary">OR</span>
    </div>

    <div class="col-md-5 mb-3">
        <label for="file">File</label>
        <input type="file" class="form-control" id="file" name="file">
        @error('file')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>

<script>
    imageCropper({
        fileInput: "#file"
        , inputLabelPreview: "#file"
        , aspectRatio: 4 / 3
    });

</script>
