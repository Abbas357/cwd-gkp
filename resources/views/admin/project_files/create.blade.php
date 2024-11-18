<x-app-layout title="Add Project File">

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add Project File</li>
    </x-slot>

    @push('style')
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.project_files.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title pb-4">Add Project File</h3>
                                <a class="btn btn-success shadow-sm" href="{{ route('admin.project_files.index') }}">All Project Files</a>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="file_name">File Name</label>
                                    <input type="text" class="form-control" id="file_name" value="{{ old('file_name') }}" placeholder="File Name" name="file_name" required>
                                    @error('file_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="file_link">File Link</label>
                                    <input type="text" class="form-control" id="file_link" value="{{ old('file_link') }}" placeholder="File Name" name="file_link">
                                    @error('file_link')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="file_type">File Type</label>
                                    <select class="form-select form-select-md" id="file_type" name="file_type" required>
                                        <option value="">Select Option</option>
                                        @foreach ($cat['file_type'] as $file_type)
                                        <option value="{{ $file_type->name }}">{{ $file_type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('file_type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
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
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="file">File</label>
                                    <input type="file" class="form-control" id="file" name="file">
                                    @error('file')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-actions mb-4 mt-2">
                                <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Add Project File</button>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    @push('script')
        <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>

        <script>
            imageCropper({
                fileInput: "#file"
                , inputLabelPreview: "#file"
                , aspectRatio: 4 / 3
            });
        </script>
    @endpush
</x-app-layout>
