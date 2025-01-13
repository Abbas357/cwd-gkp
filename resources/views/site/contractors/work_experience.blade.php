<x-main-layout>
    @push('style')
        <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    
    @include('site.contractors.partials.header')

    <div class="container">
        <form class="needs-validation" action="{{ route('contractors.experience.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card cw-shadow mb-4 rounded-0">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Work Experince
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label for="adp_number">ADP Number <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="adp_number" value="{{ old('adp_number') }}" placeholder="ADP Number" name="adp_number" required>
                            @error('adp_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="project_name">Project Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="project_name" value="{{ old('project_name') }}" placeholder="Project Name" name="project_name" required>
                            @error('project_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="project_cost">Project Cost <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="project_cost" value="{{ old('project_cost') }}" placeholder="Cost of the project" name="project_cost" required>
                            @error('project_cost')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="commencement_date">Commencement Date <abbr title="Required">*</abbr></label>
                            <input type="date" class="form-control" id="commencement_date" value="{{ old('commencement_date') }}" placeholder="Start date of project" name="commencement_date" required>
                            @error('commencement_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="completion_date">Completion Date <abbr title="Required">*</abbr></label>
                            <input type="date" class="form-control" id="completion_date" value="{{ old('completion_date') }}" placeholder="End date of project" name="completion_date" required>
                            @error('completion_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="status">Status <abbr title="Required">*</abbr></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Choose...</option>
                                <option value="completed">Completed</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="onhold">Ohhold</option>
                            </select>
                            @error('status')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card cw-shadow mb-4 rounded-0">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Attachments
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="work_order">Work Order</label>
                            <input type="file" class="form-control" id="work_order" name="work_order">
                            @error('work_order')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="workOrderPreview" src="#" alt="Work Order Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-2">
                <x-button type="submit" text="Add" />
            </div>
        </form>
    </div>
    @push('script')
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            imageCropper({
                fileInput: "#work_order"
                , inputLabelPreview: "#workOrderPreview"
                , aspectRatio: 4 / 6
                , onComplete() {
                    $("#workOrderPreview").show();
                }
            });
        });

    </script>
    @endpush
</x-main-layout>
