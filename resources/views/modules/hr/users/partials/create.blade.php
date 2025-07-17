<div class="d-flex justify-content-center">
    <label class="label" data-toggle="tooltip" title="Change Profile Picture">
        <img id="image-label-preview" src="{{ asset('admin/images/default-avatar.jpg') }}" alt="avatar"
            class="change-image img-fluid rounded-circle">
        <input type="file" id="image" name="image" class="visually-hidden" accept="image/*">
    </label>
</div>
<div class="col-md-12 mb-2">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Name"
        value="{{ old('name') }}" required>
</div>
<div class="col-md-12 mb-2">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address"
        value="{{ old('email') }}" required>
</div>
<div class="col-md-12 mb-2">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password"
        placeholder="Leave blank for default password">
</div>

<script>
    $(document).ready(function() {
        $('#image-label-preview').attr('src', '{{ asset('admin/images/default-avatar.jpg') }}');
    });

    imageCropper({
        fileInput: '#image',
        inputLabelPreview: '#image-label-preview',
        aspectRatio: 9 / 10,
    });
</script>
