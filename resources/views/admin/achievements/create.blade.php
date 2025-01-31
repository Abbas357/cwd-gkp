<x-app-layout title="Add Achievement">
    @push('style')
    <link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add Achievement</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.achievements.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title pb-4">Add Achievement</h3>
                                <a class="btn btn-success shadow-sm" href="{{ route('admin.achievements.index') }}">All Achievements</a>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="Title" name="title" required>
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" id="location" value="{{ old('location') }}" placeholder="Location" name="location">
                                    @error('location')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="content">Content</label>
                                    <div class="mb-3">
                                        <textarea name="content" id="content" class="form-control" style="height:150px">{{ old('content') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" value="{{ old('start_date') }}" placeholder="Start Date & Time" name="start_date" required>
                                    @error('start_date')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="end_date" value="{{ old('end_date') }}" placeholder="End Date & Time" name="end_date" required>
                                    @error('end_date')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="achievement_files">Achievement Files</label>
                                    <input type="file" class="form-control" id="achievement_files" name="achievement_files[]" multiple>
                                    @error('achievement_files')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-actions mb-4 mt-2">
                                <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Add Achievement</button>
                            </div>
                        </div>
                        <div class="col-md-4 d-none d-sm-block">
                            <div class="row g-5">
                                <div class="col-md-12 col-lg-12 order-md-last">
                                    <h4 class="mb-3">
                                        <span class="text-secondary">Statistics</span>
                                    </h4>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Total Achievements</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['totalCount'] }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Publish Achievements</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['publishedCount'] }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Unpublished Achievements</h6>
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

    @push('script')
    <script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
    <script>
        $(document).ready(function() {
        
            $('#content').summernote({
                height: 200
            , });

            $("#start_date").flatpickr({
                enableTime: true
                , dateFormat: "Y-m-d H:i:S",
            });

            $("#end_date").flatpickr({
                enableTime: true
                , dateFormat: "Y-m-d H:i:S"
            , });

        });

    </script>
    @endpush
</x-app-layout>
