<x-app-layout title="Add Stories">
    @push('style')
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Add User</li>
    </x-slot>

    <div class="wrapper">
        <div class="row mb-3 d-none">
            <div class="col-md-4 mx-auto">
                <label for="load-users">All Users</label>
                <select class="form-select form-select-md" data-placeholder="Choose" id="load-users" name="user">
                </select>
            </div>
        </div>
        <form class="needs-validation" action="{{ route('admin.stories.store') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title pb-4">Fill all the fields</h3>

                            <div class="row mb-4">
                                <div class="col d-flex justify-content-center align-items-center">
                                    <label class="label" data-toggle="tooltip" title="Change Profile Picture">
                                        <img src="{{ asset('admin/images/upload-image.jpg') }}" style="height:100px; width:70px;cursor:pointer" id="image-label-preview" alt="avatar" class="img-fluid">
                                        <input type="file" id="image" name="image" class="sr-only" accept="image/*">
                                    </label>
                                </div>
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

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title pb-4">Statistics</h3>
                            
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Create Story</button>
                </div>
            </div>
        </form>

    </div>

    @push("script")
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            imageCropper({
                fileInput: '#image',
                inputLabelPreview: '#image-label-preview',
                aspectRatio: 1 / 1.6471
            });
        });

    </script>
    @endpush
</x-app-layout>
