<x-app-layout title="Add Download">

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add Download</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.downloads.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title pb-4">Add Download</h3>
                                <a class="btn btn-success shadow-sm" href="{{ route('admin.downloads.index') }}">All Downloads</a>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="file_name">File Name</label>
                                    <input type="text" class="form-control" id="file_name" value="{{ old('file_name') }}" placeholder="File Name" name="file_name" required>
                                    @error('file_name')
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
                                    <label for="file_category">Category Type</label>
                                    <select class="form-select form-select-md" id="file_category" name="file_category" required>
                                        <option value="">Select Option</option>
                                        @foreach ($cat['file_category'] as $file_category)
                                        <option value="{{ $file_category->name }}">{{ $file_category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('file_category')
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
                        <div class="col-md-4 d-none d-sm-block">
                            <div class="row g-5">
                                <div class="col-md-12 col-lg-12 order-md-last">
                                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-secondary">Statistics</span>
                                        <a class="btn btn-light" href="{{ route('admin.downloads.index') }}">All Downloads</a>
                                    </h4>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Total Downloads</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['totalCount'] }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Publish downloads</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['publishedCount'] }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Unpublished Downloads</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['unPublishedCount'] }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Archived</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['archivedCount'] }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </form>
    </div>
</x-app-layout>
