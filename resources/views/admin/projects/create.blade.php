<x-app-layout title="Add Project">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add Project</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.projects.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title pb-4">Add Project</h3>
                                <a class="btn btn-success shadow-sm" href="{{ route('admin.projects.index') }}">All Projects</a>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="Project Name" name="name" required>
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="funding_source">Funding Source</label>
                                    <input type="text" class="form-control" id="funding_source" value="{{ old('funding_source') }}" placeholder="Funding Source" name="funding_source" required>
                                    @error('funding_source')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="attachment">Attachment</label>
                                    <input type="file" class="form-control" id="attachment" value="{{ old('attachment') }}" placeholder="Funding Source" name="attachment" required>
                                    @error('attachment')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="introduction">Introduction</label>
                                    <div class="mb-3">
                                        <textarea name="introduction" id="introduction" class="form-control" style="height:150px">{{ old('introduction') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" id="location" value="{{ old('location') }}" placeholder="Location" name="location" required>
                                    @error('location')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="budget">Budget</label>
                                    <input type="text" class="form-control" id="budget" value="{{ old('budget') }}" placeholder="Budget" name="budget" required>
                                    @error('budget')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" value="{{ old('start_date') }}" placeholder="Start Date" name="start_date" required>
                                    @error('start_date')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="end_date" value="{{ old('end_date') }}" placeholder="End Date" name="end_date" required>
                                    @error('end_date')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-actions mb-3 mt-2">
                                <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Add Project</button>
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

            $('#introduction').summernote({
                height: 300,
            });

            imageCropper({
                fileInput: "#attachment"
                , inputLabelPreview: "#previewProject"
                , aspectRatio: 4 / 3
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
