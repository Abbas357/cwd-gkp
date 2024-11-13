<x-app-layout title="Add Stories">
    @push('style')
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add User</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.stories.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title pb-4">Post a story</h3>
                                <a class="btn btn-success shadow-sm" href="{{ route('admin.stories.index') }}">All Stories</a>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name">Title</label>
                                    <input type="text" class="form-control" id="name" value="{{ old('title') }}" placeholder="Title" name="title" required>
                                    @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col mb-3">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" id="image" name="image" required>
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-actions">
                                <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Create Story</button>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title pb-4">Image Preview</h3>
                            <img src="#" class="d-none" id="preview-image" style="width:70%; border-radius: 10px" alt="Preview">
                        </div>
                    </div>
                </div>
                
            </div>
        </form>

    </div>

    @push("script")
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            imageCropper({
                fileInput: '#image'
                , inputLabelPreview: '#preview-image'
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $('#preview-image').removeClass('d-none');
                }
            });
        });

    </script>
    @endpush
</x-app-layout>
