<x-main-layout title="Achievements">
    @push('style')
    <style>
        .achievement-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            margin-bottom: 1.5rem;
        }

        .achievement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .achievement-title {
            color: #2d3748;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .achievement-title:hover {
            color: #4a5568;
            text-decoration: none;
        }

        .achievement-meta {
            display: flex;
            gap: 1rem;
            align-items: center;
            color: #718096;
            font-size: 0.9rem;
        }

        .achievement-meta i {
            margin-right: 0.4rem;
            color: #a0aec0;
        }

        .pagination .page-link {
            border-radius: 8px;
            margin: 0 4px;
            border: none;
            color: #4a5568;
        }

        .pagination .page-item.active .page-link {
            background: #4a5568;
            color: white;
        }

        @media (max-width: 768px) {
            .achievement-card {
                margin-bottom: 1rem;
            }
        }
    </style>
    @endpush

    <x-slot name="breadcrumbTitle">
        Achievements
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Achievements</li>
    </x-slot>

    <div class="container py-4">
        <div class="row">
            @foreach ($achievements as $achievement)
            <div class="col-12 mb-4">
                <div class="achievement-card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start">
                            <div class="mb-3 mb-md-0">
                                <a href="{{ route('achievements.show', $achievement->slug) }}" class="achievement-title">
                                    <h4 class="mb-2">{{ $achievement->title }}</h4>
                                </a>
                                <div class="achievement-meta">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $achievement->published_at->format('M d, Y') }}
                                    </span>
                                    <span class="d-inline-flex align-items-center">
                                        <i class="far fa-eye"></i>
                                        {{ $achievement->views_count }} views
                                    </span>
                                </div>
                            </div>
                            <div class="text-md-end">
                                <a href="{{ route('achievements.show', $achievement->slug) }}" 
                                   class="cw-btn m-4">
                                    View Details <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $achievements->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-main-layout>