<x-main-layout title="{{ $pageData['title'] }}">
    @push('style')
        <link rel="stylesheet" href="{{ asset('site/lib/page-flip/style.min.css') }}">
    @endpush
    <x-slot name="breadcrumbTitle">
        {{ $pageData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Pages</li>
    </x-slot>

    <div class="container mt-3">
        <div class="description mt-4">
            <p>{!! nl2br($pageData['content']) !!}</p>
        </div>

        <div id="book"></div>
    </div>
    @push('script')
        <script src="{{ asset('site/lib/page-flip/script.min.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Array of image paths
                const images = @json($pageData['attachments']); 
                console.log(images)

                // Initialize the PageFlip instance
                const pageFlip = new St.PageFlip(document.getElementById('book'), {
                    width: 600,
                    height: 600,
                    size: "stretch"
                });

                // Load images into the flipbook
                pageFlip.loadFromImages(images);
            });
        </script>
    @endpush
</x-main-layout>
