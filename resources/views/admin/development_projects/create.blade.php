<x-app-layout title="Add Developmental Project">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add Developmental Project</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.development_projects.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title pb-4">Add Developmental Project</h3>
                                <a class="btn btn-success shadow-sm" href="{{ route('admin.development_projects.index') }}">All Dev. Projects</a>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="Project Name" name="name" required>
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="commencement_date">Commencement Date</label>
                                    <input type="date" class="form-control" id="commencement_date" value="{{ old('commencement_date') }}" placeholder="Funding Source" name="commencement_date" required>
                                    @error('commencement_date')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="total_cost">Total Cost (in Millions)</label>
                                    <input type="number" class="form-control" id="total_cost" value="{{ old('total_cost') }}" placeholder="eg. 325" name="total_cost" required>
                                    @error('total_cost')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="introduction">Introduction</label>
                                    <div class="mb-3">
                                        <textarea name="introduction" id="introduction" class="form-control" style="height:100px">{{ old('introduction') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-4">
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
                                <div class="col-md-4 mb-4">
                                    <label for="chiefEnginner">Chief Engineer</label>
                                    <select class="form-select form-select-md" id="chiefEnginner" name="chiefEnginner">
                                        <option value="">Select Option</option>
                                        @foreach ($cat['chiefEngineers'] as $chiefEngineer)
                                        <option value="{{ $chiefEngineer->id }}">{{ $chiefEngineer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('chiefEnginner')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="superintendentEngineer">Superintendent Engineer</label>
                                    <select class="form-select form-select-md" id="superintendentEngineer" name="superintendentEngineer">
                                        <option value="">Select Option</option>
                                        @foreach ($cat['superintendentEngineers'] as $superintendentEngineer)
                                        <option value="{{ $superintendentEngineer->id }}">{{ $superintendentEngineer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('superintendentEngineer')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="progress_percentage" class=" mb-1">Progress Percentage: <span id="progress_value" class="bg-light px-2 py-1  fw-bold">50</span>%</label>
                                    <input type="range" class="form-control" id="progress_percentage" name="progress_percentage" 
                                           value="{{ old('progress_percentage', 50) }}" min="1" max="100" required>
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
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="work_location">Work Location</label>
                                    <input type="text" class="form-control" id="work_location" value="{{ old('work_location') }}" placeholder="Work Location" name="work_location" required>
                                    @error('work_location')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="year_of_completion">Year of Completion</label>
                                    <input type="date" class="form-control" id="year_of_completion" value="{{ old('year_of_completion') }}" placeholder="Funding Source" name="year_of_completion" required>
                                    @error('year_of_completion')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-actions mb-3 mt-2">
                                <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Add Developmental Project</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @push('script')
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
                height:150
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

            $('#load-users').select2({
                theme: "bootstrap-5"
                , dropdownParent: $('#load-users').parent()
                , ajax: {
                    url: '{{ route("admin.users.api") }}'
                    , dataType: 'json'
                    , data: function(params) {
                        return {
                            q: params.term
                            , page: params.page || 1
                        };
                    }
                    , processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items
                            , pagination: {
                                more: data.pagination.more
                            }
                        };
                    }
                    , cache: true
                }
                , minimumInputLength: 0
                , templateResult(user) {
                    return user.designation;
                }
                , templateSelection(user) {
                    return user.designation;
                }
            });

        });

    </script>
    @endpush
</x-app-layout>