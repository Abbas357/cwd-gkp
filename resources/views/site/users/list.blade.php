<x-main-layout title="List of All positions based on {{ $designation }}">
    @push('style')
    <style>
        .user-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 12px;
        }
    
        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
    
        .card-title {
            font-size: 1.25rem;
            color: #0056b3;
        }
    
        .card-text {
            font-size: 0.9rem;
            line-height: 1.5;
        }
    
        .btn-animate {
            background-color: #0056b3;
            color: #ffffff;
            border-radius: 20px;
            transition: background-color 0.3s, transform 0.3s;
        }
    
        .btn-animate:hover {
            background-color: #00408b;
            transform: scale(1.05);
        }
    
        .view-details-btn {
            font-weight: bold;
        }
    </style>
    <x-slot name="breadcrumbTitle">
        Previous List ({{ ucfirst($designation) }})
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Positions</li>
    </x-slot>
    @endpush
    <div class="container mt-3">
        <div class="row">
            <h1 class="display-6 py-2 bg-light"></h1>
            @foreach ($userData as $user)
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-3">
                <div class="card user-card shadow-sm rounded border-0 overflow-hidden">
                    <img src="{{ $user['profile_pictures'] }}" class="card-img-top img-fluid" style="object-fit: cover;" alt="{{ $user['name'] }}">
                    <div class="card-body text-center p-2">
                        <h5 class="card-title font-weight-bold text-primary mb-2">{{ $user['name'] }}</h5>
                        <p class="card-text text-muted mb-1 fs-5">{{ $user['title'] }}</p>
                        <button class="btn-animate view-details-btn mt-1 px-2 py-1" data-id="{{ $user['id'] }}">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
    @push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            pushStateModal({
                title: 'Details'
                , fetchUrl: '{{ route("positions.details", ":id") }}'
                , btnSelector: '.view-details-btn'
                , modalSize: 'lg'
                , modalType: 'details'
            });
        });
    </script>
    @endpush
</x-main-layout>
