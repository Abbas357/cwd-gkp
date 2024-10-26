<x-app-layout title="Add Page">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
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
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-secondary">Fill all the fields</span>
                            </h4>
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
                                    <label for="attachment">Attachment</label>
                                    <input type="file" class="form-control" id="attachment" name="attachment" required>
                                    @error('attachment')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <img src="#" style="width:100px" class="image-preview rounded d-none" />
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
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#content').summernote({
                height: 300,
            });

            imageCropper({
                fileInput: "#attachment"
                , inputLabelPreview: ".image-preview"
                , aspectRatio: 1 / 1, 
                onComplete(){
                    $('.image-preview').removeClass('d-none')
                }
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
