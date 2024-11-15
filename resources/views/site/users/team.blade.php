<x-main-layout title="Team">
    @push('style')
    <style>
        .user-card {
            background-color: #F2F3F4 !important;
            box-shadow: 5px 5px 5px #eee;
            border: 1px solid #ddd;
            border-radius: 10px
        }
    </style>
    @endpush
    <x-slot name="breadcrumbTitle">
        Our Team
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Team</li>
    </x-slot>

    <div class="container py-2">
        <div class="row">
            @foreach ($users as $user)
            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-2 mb-4">
                <div class="team-item h-100 user-card">
                    <div class="team-img">
                        <div class="team-img-efects">
                            <img src="{{ $user['image'] }}" class="img-fluid w-100 rounded-top" alt="{{ $user['name'] }}">
                        </div>
                        <div class="team-icon rounded-pill p-2 d-flex justify-content-center align-items-center">
                            <a class="btn btn-square btn-primary rounded-circle mx-1" href="{{ $user['facebook'] }}" target="_blank"><i class="bi bi-facebook"></i></a>
                            <a class="btn btn-square btn-info rounded-circle mx-1" href="{{ $user['twitter'] }}" target="_blank"><i class="bi bi-twitter"></i></a>
                            <a class="btn btn-square btn-success rounded-circle mx-1" href="https://wa.me/{{ $user['whatsapp'] }}" target="_blank"><i class="bi bi-whatsapp"></i></a>
                            <a class="btn btn-square btn-secondary rounded-circle mx-1" href="tel:{{ $user['mobile_number'] }}" target="_blank"><i class="bi bi-telephone"></i></a>
                        </div>
                    </div>
                    <div class="team-title text-center rounded-bottom p-4 d-flex flex-column" style="height:220px; overflow: hidden;">
                        <div class="team-title-inner mb-auto" style="overflow-y: auto;">
                            <h5 class="fs-6 mt-3">{{ $user['name'] }}</h5>
                            <p class="mb-3">{{ $user['position'] }}</p>
                        </div>
                        <a href="{{ route('positions.show', ['position' => $user['position']]) }}" class="btn-animate mt-3">View Previous</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-main-layout>
