<x-app-layout  :showAside="false" title="Edit Profile">
    @push('style')
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="header">
        <li class="breadcrumb-item" aria-current="page">Profile</li>
    </x-slot>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="p-4 border h-100">
                <div class="max-w-xl">
                    @include('misc.profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>
    
        <div class="col-md-6">
            <div class="p-4 border h-100">
                <div class="max-w-xl">
                    @include('misc.profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>

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
