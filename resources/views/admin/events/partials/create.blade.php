<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<div class="row mx-1" id="step-1">
    <div class="col-md-6 mb-3">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="Title" name="title" required>
        @error('title')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="location">Location</label>
        <input type="text" class="form-control" id="location" value="{{ old('location') }}" placeholder="eg. Conference Room" name="location">
        @error('location')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="start_datetime">Start Date & Time</label>
        <input type="date" class="form-control" id="start_datetime" value="{{ old('start_datetime') }}" placeholder="Start Date & Time" name="start_datetime" required>
        @error('start_datetime')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="end_datetime">End Date & Time</label>
        <input type="date" class="form-control" id="end_datetime" value="{{ old('end_datetime') }}" placeholder="End Date & Time" name="end_datetime" required>
        @error('end_datetime')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mx-1" id="step-2">
    <div class="col-md-6 mb-3">
        <label for="event_type">Event Type</label>
        <select class="form-select form-select-md" id="event_type" name="event_type">
            <option value="">Select Option</option>
            @foreach ($cat['event_type'] as $event_type)
            <option value="{{ $event_type }}">{{ $event_type }}</option>
            @endforeach
        </select>
        @error('event_type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="organizer">Organizer</label>
        <input type="text" class="form-control" id="organizer" value="{{ old('organizer') }}" placeholder="eg. SOG" name="organizer">
        @error('organizer')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="chairperson">Chairperson</label>
        <input type="text" class="form-control" id="chairperson" value="{{ old('chairperson') }}" placeholder="eg. Secretary C&W" name="chairperson">
        @error('chairperson')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="participants_type">Participants Type</label>
        <select class="form-select form-select-md" id="participants_type" name="participants_type">
            <option value="">Select Option</option>
            @foreach ($cat['participants_type'] as $participants_type)
            <option value="{{ $participants_type }}">{{ $participants_type }}</option>
            @endforeach
        </select>
        @error('participants_type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="no_of_participants">No. of Participants</label>
        <input type="number" class="form-control" id="no_of_participants" value="{{ old('no_of_participants') }}" placeholder="eg. 12" name="no_of_participants">
        @error('no_of_participants')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mx-1" id="step-3">
    <div class="col-md-12 mb-3">
        <label for="images">Images</label>
        <input type="file" class="form-control" id="images" name="images[]" multiple required>
        @error('images')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control" style="height:150px">{{ old('description') }}</textarea>
    </div>
</div>


<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script>
    $(document).ready(function() {
        
        $('#description').summernote({
            height: 200
        , });

    });

</script>
