<x-app-layout title="Add Download">

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add Download</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.project_files.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-secondary">Fill all the fields</span>
                            </h4>
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
                                    <input type="file" class="form-control" id="file" name="file" required>
                                    @error('file')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-actions mb-4 mt-2">
                                <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Add Download</button>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
</x-app-layout>
