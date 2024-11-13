<x-app-layout title="Add Gallery">
    @push('style')
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add Gallery</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.gallery.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title pb-4">Add Gallery</h3>
                                <a class="btn btn-success shadow-sm" href="{{ route('admin.gallery.index') }}">All galleries</a>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" value="{{ old('title') }}" placeholder="File Name" name="title" required>
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="type">Gallery Type</label>
                                    <select class="form-select form-select-md" id="type" name="type" required>
                                        <option value="">Select Option</option>
                                        @foreach ($cat['gallery_type'] as $type)
                                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="file">File</label>
                                    <input type="file" class="form-control" id="file" name="file" required>
                                    @error('file')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <img src="#" style="width:140px; border-radius:5px" class="mt-2" id="previewGallery" alt="Gallery">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="description">Description</label>
                                    <div class="mb-3">
                                        <textarea name="description" id="description" class="form-control" style="height:150px">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions mb-4 mt-2">
                                <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Add Gallery</button>
                            </div>
                        </div>
                        <div class="col-md-4 d-none d-sm-block">
                            <div class="row g-5">
                                <div class="col-md-12 col-lg-12 order-md-last">
                                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-secondary">Statistics</span>
                                        <a class="btn btn-light" href="{{ route('admin.gallery.index') }}">All Galleries</a>
                                    </h4>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Total Gallery</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['totalCount'] }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Publish Gallery</h6>
                                            </div>
                                            <span class="text-body-secondary">{{ $stats['publishedCount'] }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between lh-lg">
                                            <div>
                                                <h6 class="my-0">Unpublished Gallery</h6>
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
            </div>
        </form>
    </div>
    @push('script')
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            imageCropper({
                fileInput: "#file"
                , inputLabelPreview: "#previewGallery"
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

        });

    </script>
    @endpush
</x-app-layout>
