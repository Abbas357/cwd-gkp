<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<div class="row mx-1">
    
    <div class="col-md-6 mb-4">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="Title" name="title" required>
        @error('title')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-4">
        <label for="location">Location</label>
        <input type="text" class="form-control" id="location" value="{{ old('location') }}" placeholder="Location" name="location">
        @error('location')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="content">Content</label>
        <div class="mb-3">
            <textarea name="content" id="content" class="form-control" style="height:150px">{{ old('content') }}</textarea>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label for="start_date">Start Date</label>
        <input type="date" class="form-control" id="start_date" value="{{ old('start_date') }}" placeholder="Start Date & Time" name="start_date" required>
        @error('start_date')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="end_date">End Date</label>
        <input type="date" class="form-control" id="end_date" value="{{ old('end_date') }}" placeholder="End Date & Time" name="end_date" required>
        @error('end_date')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-4">
        <label for="achievement_files">Achievement Files</label>
        <input type="file" class="form-control" id="achievement_files" name="achievement_files[]" multiple>
        @error('achievement_files')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#content').summernote({
            height: 200
        , });

        $("#start_date").flatpickr({
            enableTime: true
            , dateFormat: "Y-m-d H:i:S"
        , });

        $("#end_date").flatpickr({
            enableTime: true
            , dateFormat: "Y-m-d H:i:S"
        , });

    });

</script>
