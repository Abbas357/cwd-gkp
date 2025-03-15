<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<div class="row" id="step-1">
    <div class="col-md-12 mb-3">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="Project Name" name="name" required>
        @error('name')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label for="introduction">Introduction</label>
        <textarea name="introduction" id="introduction" class="form-control" style="height:100px">{{ old('introduction') }}</textarea>
    </div>
</div>

<div class="row" id="step-2">
    <div class="col-md-6 mb-3">
        <label for="work_location">Work Location</label>
        <input type="text" class="form-control" id="work_location" value="{{ old('work_location') }}" placeholder="eg. Near Park" name="work_location">
        @error('work_location')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="total_cost">Total Cost (in Millions)</label>
        <input type="text" class="form-control" id="total_cost" value="{{ old('total_cost') }}" placeholder="eg. 325" name="total_cost">
        @error('total_cost')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="district">District</label>
        <select class="form-select form-select-md" id="district" name="district_id">
            <option value="">Select Option</option>
            @foreach ($cat['districts'] as $district)
            <option value="{{ $district->id }}">{{ $district->name }}</option>
            @endforeach
        </select>
        @error('district')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="chiefEnginner">Chief Engineer</label>
        <select class="form-select form-select-md" id="chiefEnginner" name="chiefEnginner">
            <option value="">Select Option</option>
            @foreach ($cat['chiefEngineers'] as $chiefEngineer)
            <option value="{{ $chiefEngineer->id }}">{{ $chiefEngineer->name }} - {{ $chiefEngineer->currentPosting->office->name }}</option>
            @endforeach
        </select>
        @error('chiefEnginner')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="superintendentEngineer">Superintendent Engineer</label>
        <select class="form-select form-select-md" id="superintendentEngineer" name="superintendentEngineer">
            <option value="">Select Option</option>
            @foreach ($cat['superintendentEngineers'] as $superintendentEngineer)
            <option value="{{ $superintendentEngineer->id }}">{{ $superintendentEngineer->name }} - {{ $superintendentEngineer->currentPosting->office->name }}</option>
            @endforeach
        </select>
        @error('superintendentEngineer')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row" id="step-3">
    <div class="col-md-6 mb-3">
        <label for="commencement_date">Commencement Date</label>
        <input type="date" class="form-control" id="commencement_date" value="{{ old('commencement_date') }}" name="commencement_date" required>
        @error('commencement_date')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="year_of_completion">Year of Completion</label>
        <input type="date" class="form-control" id="year_of_completion" value="{{ old('year_of_completion') }}" name="year_of_completion">
        @error('year_of_completion')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row" id="step-4">
    <div class="col-md-6 mb-3">
        <label for="progress_percentage" class=" mb-1">Progress Percentage: <span id="progress_value" class="bg-light px-2 py-1  fw-bold">50</span>%</label>
        <input type="range" class="form-control" id="progress_percentage" name="progress_percentage" value="{{ old('progress_percentage', 50) }}" min="1" max="100">
        @error('progress_percentage')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="attachments">Images</label>
        <input type="file" class="form-control" id="attachments" value="{{ old('attachments') }}" name="attachments[]" multiple required>
        @error('attachments')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script>
    $(document).ready(function() {

        imageCropper({
            fileInput: "#attachment"
            , inputLabelPreview: "#previewProject"
            , aspectRatio: 4 / 3
        });

        $('#introduction').summernote({
            height: 150
        })

        const rangeInput = document.getElementById('progress_percentage');
        const rangeDisplay = document.getElementById('progress_value');

        rangeDisplay.textContent = rangeInput.value;

        rangeInput.addEventListener('input', function() {
            rangeDisplay.textContent = rangeInput.value;
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
