<x-main-layout title="{{ $pageData['title'] }}">

    @push('style')
        <link rel="stylesheet" href="{{ asset('site/lib/lightbox/lightbox.min.css') }}" />
    @endpush

    <x-slot name="breadcrumbTitle">
        {{ $pageData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Pages</li>
    </x-slot>

    <div class="container mt-3">
        <p style="text-align: right"><strong>Views:</strong> {{ $pageData['views_count'] }}</p>
        <div class="description mt-4">
            <p>{!! nl2br($pageData['content']) !!}</p>
        </div>

        <div class="images mt-4">
            <h5>Images</h5>
            <div class="row">
                @foreach($pageData['attachments'] as $image)
                    <div class="col-md-3 mb-3">
                        <a href="{{ $image }}" data-lightbox="page-attachments" data-title="{{ $pageData['title'] }}">
                            <img src="{{ $image }}" class="img-fluid rounded mb-3" alt="{{ $pageData['title'] }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <x-sharer :title="$pageData['title'].' - '.config('app.name')" :url="url()->current()" />

    @push('script')
        <script src="{{ asset('site/lib/lightbox/lightbox.min.js') }}"></script>
        <script>
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'disableScrolling': true,
            });
        </script>
    @endpush
</x-main-layout>
