<x-app-layout>
    @push('style')
    <link href="{{ asset('plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item" aria-current="page">Profile</li>
    </x-slot>

    <div class="py-12">
        <div class="p-4 shadow">
            <div class="max-w-xl">
                @include('backend.profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 shadow">
            <div class="max-w-xl">
                @include('backend.profile.partials.update-password-form')
            </div>
        </div>
    </div>
    @push('script')
    <script src="{{ asset('plugins/cropper/js/cropper.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            imageCropper({
                fileInput: '#image',
                inputLabelPreview: '#image-label-preview',
            });
        });
    </script>
    @endpush
</x-app-layout>
