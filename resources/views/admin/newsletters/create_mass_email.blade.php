<x-app-layout title="Send email to Subscribers">
    @push('style')
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page"> Send email to Subscribers</li>
    </x-slot>

    <div class="wrapper">
        <form class="needs-validation" action="{{ route('admin.newsletter.send_mass_email') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card">
                <div class="card-body">
                    <h3>Send Email updates to Subscribers
                    </h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="email_content">Email Content</label>
                                    <div class="mb-3">
                                        <textarea name="email_content" id="email_content" class="form-control" style="height:200px">{{ old('email_content') }}</textarea>
                                        @error('email_content')
                                        <div>{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="send_as_queue" class="form-label">Send as Queue</label>
                                    <select class="form-select" id="send_as_queue" name="send_as_queue">
                                        <option value=""> Choose... </option>
                                        <option value="no" {{ old('send_as_queue') == 'no' ? 'selected' : '' }}>No</option>
                                        <option value="yes" {{ old('send_as_queue') == 'yes' ? 'selected' : '' }}>Yes</option>
                                    </select>
                                    @error('send_as_queue')
                                    <div>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="attachment">Attachment</label>
                                    <input type="file" class="form-control" id="attachment" name="attachment">
                                    @error('attachment')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-actions mb-4 mt-2">
                                <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Send</button>
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
    <script>
        $(document).ready(function() {

            $('#email_content').summernote({
                height: 300,
            });

            imageCropper({
                fileInput: "#attachment"
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
