<x-main-layout title="{{ $pageData['title'] }}">
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-2" style="max-width: 900px;">
            <h3 class="text-white display-3 mb-4">{{ $pageData['title'] }}</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('site') }}">Home</a></li>
                <li class="breadcrumb-item active text-white">Pages</li>
            </ol>    
        </div>
    </div>
    <div class="container mt-3">
        <h1 class="page-title fs-3 py-2 bg-light px-2">{{ $pageData['title'] }}</h1>
        <img 
            src="{{ $pageData['image']}}" style="width: 400px" class="my-4" alt="{{ $pageData['title'] }}">
        <div class="description mt-4">
            <h2>Description</h2>
            <p>{!! nl2br($pageData['content']) !!}</p>
        </div>
    </div>
</x-main-layout>
