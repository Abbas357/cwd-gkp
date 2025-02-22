<x-app-layout title="Add Page">
    @push('style')
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add Page</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.pages.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title pb-4">Add Page</h3>
                                <a class="btn btn-success shadow-sm" href="{{ route('admin.pages.index') }}">All Pages</a>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="page_type">Page Type</label>
                                    <select class="form-select form-select-md" id="page_type" name="page_type" required>
                                        <option value="">Select Option</option>
                                        @foreach ($cat['page_type'] as $type)
                                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('page_type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="title">Page Title</label>
                                    <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="Page title" name="title" required>
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="attachments">Attachments</label>
                                    <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                                    @error('attachments')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="content">Content</label>
                                    <div class="mb-3">
                                        <textarea name="content" id="content" class="form-control">{{ old('content') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions mb-3 mt-2">
                                <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Add Page</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @push('script')
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
    @endpush
</x-app-layout>
