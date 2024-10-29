<x-main-layout title="{{ $pageData['title'] }}">
    
    <x-slot name="breadcrumbTitle">
        {{ $pageData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Pages</li>
    </x-slot>

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
