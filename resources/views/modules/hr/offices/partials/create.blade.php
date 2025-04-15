<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="Office name" name="name" required>
        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="type">Office Type</label>
        <select class="form-select" id="type" name="type">
            <option value="">Select Type</option>
            @foreach($officeTypes as $type)
                <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>
        <div class="form-text">
            <small class="text-muted">Higher level offices doesn't have district assignment.</small>
        </div>
        @error('type')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="parent_id">Parent Office</label>
        <select class="form-select" id="parent_id" name="parent_id">
            <option value="">Select Parent Office (if any)</option>
            @foreach($offices as $office)
                <option value="{{ $office->id }}">{{ $office->name }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="district_id">District</label>
        <select class="form-select" id="district_id" name="district_id">
            <option value="">Select District</option>
            @foreach($districts as $district)
                <option value="{{ $district->id }}">{{ $district->name }}</option>
            @endforeach
        </select>
        <div class="form-text">
            <small class="text-muted">Only one office can be directly associated with a district.</small>
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <label for="job_description">Job Description</label>
        <div class="mb-3">
            <textarea name="job_description" id="job_description" class="form-control">{{ old('job_description') }}</textarea>
        </div>
    </div>

</div>

<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#job_description').summernote({
            height: 250
        });
        
    })

</script>
