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

        <div id="book" style="border: 1px solid #aaa"></div>
    </div>
    @push('script')
        <script src="{{ asset('site/lib/page-flip/script.min.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const images = @json($pageData['attachments']); 
                console.log(images)

                const pageFlip = new St.PageFlip(document.getElementById('book'), {
                    width: 600,
                    height: 600,
                    size: "stretch"
                });

                pageFlip.loadFromImages(images);
            });
        </script>
    @endpush
</x-main-layout>
