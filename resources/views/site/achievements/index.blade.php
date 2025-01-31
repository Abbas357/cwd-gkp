<x-main-layout title="Achievements">
    @push('style')
    <style>
        .list-group-item {
            display: block !important;
            margin-block: .7rem;
            box-shadow: 2px 3px 5px #00000011, -2px -3px 5px #00000011;
        }
        .Achievement-image {
            width: 170px;
            height: 110px
        }
    </style>
    @endpush
    <x-slot name="breadcrumbTitle">
        Achievements
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Achievements</li>
    </x-slot>

    <div class="container my-4">

        <div class="list-group">
            @foreach ($achievements as $achievement)
            <div class="list-group-item py-2">
                <div class="row p-1">

                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('achievements.show', $achievement->slug) }}">
                                    <h5 class="mt-0">{{ $achievement->title }}</h5>
                                </a>
                            </div>
                    
                            <!-- Right Section -->
                            <div class="text-end">
                                <div>
                                    <small class="text-muted">{{ $achievement->published_at->format('M d, Y') }}</small>
                                </div>
                                <div>
                                    <small class="text-muted">Views: {{ $achievement->views_count }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $achievements->links() }}
        </div>
    </div>
</x-main-layout>
