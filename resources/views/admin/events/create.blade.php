<x-app-layout title="Add Event">
    @push('style')
    <link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add Event</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.events.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title pb-4">Add Event</h3>
                                <a class="btn btn-success shadow-sm" href="{{ route('admin.events.index') }}">All Events</a>
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
                                    <input type="text" class="form-control" id="location" value="{{ old('location') }}" placeholder="eg. Conference Room" name="location">
                                    @error('location')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="description">Description</label>
                                    <div class="mb-3">
                                        <textarea name="description" id="description" class="form-control" style="height:150px">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_datetime">Start Date & Time</label>
                                    <input type="date" class="form-control" id="start_datetime" value="{{ old('start_datetime') }}" placeholder="Start Date & Time" name="start_datetime" required>
                                    @error('start_datetime')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="end_datetime">End Date & Time</label>
                                    <input type="date" class="form-control" id="end_datetime" value="{{ old('end_datetime') }}" placeholder="End Date & Time" name="end_datetime" required>
                                    @error('end_datetime')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="participants_type">Participants Type</label>
                                    <select class="form-select form-select-md" id="participants_type" name="participants_type">
                                        <option value="">Select Option</option>
                                        @foreach ($cat['participants_type'] as $participants_type)
                                        <option value="{{ $participants_type }}">{{ $participants_type }}</option>
                                        @endforeach
                                    </select>
                                    @error('participants_type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="event_type">Event Type</label>
                                    <select class="form-select form-select-md" id="event_type" name="event_type">
                                        <option value="">Select Option</option>
                                        @foreach ($cat['event_type'] as $event_type)
                                        <option value="{{ $event_type }}">{{ $event_type }}</option>
                                        @endforeach
                                    </select>
                                    @error('event_type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="organizer">Organizer</label>
                                    <input type="text" class="form-control" id="organizer" value="{{ old('organizer') }}" placeholder="eg. SOG" name="organizer">
                                    @error('organizer')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="chairperson">Chairperson</label>
                                    <input type="text" class="form-control" id="chairperson" value="{{ old('chairperson') }}" placeholder="eg. Secretary C&W" name="chairperson">
                                    @error('chairperson')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="no_of_participants">No. of Participants</label>
                                    <input type="number" class="form-control" id="no_of_participants" value="{{ old('no_of_participants') }}" placeholder="eg. 12" name="no_of_participants">
                                    @error('no_of_participants')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="images">Images</label>
                                    <input type="file" class="form-control" id="images" name="images[]" multiple required>
                                    @error('images')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-actions mb-4 mt-2">
                                <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Add Event</button>
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
                                                <h6 class="my-0">Total Events</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['totalCount'] }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Publish Events</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['publishedCount'] }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Unpublished Events</h6>
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
            $('#description').summernote({
                height: 200
            , });

            $("#start_datetime").flatpickr({
                enableTime: true
                , dateFormat: "Y-m-d H:i:S",
            });

            $("#end_datetime").flatpickr({
                enableTime: true
                , dateFormat: "Y-m-d H:i:S"
            , });

        });

    </script>
    @endpush
</x-app-layout>
