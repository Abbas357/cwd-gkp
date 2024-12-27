<x-main-layout title="Team">
    @push('style')
    <style>
        .user-card {
            background-color: #F2F3F4 !important;
            box-shadow: 5px 5px 5px #eee;
            border: 1px solid #ddd;
            border-radius: 10px
        }
        .text-no-overflow {
            white-space:nowrap;
            text-overflow: ellipsis;
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
    <ul class="nav nav-tabs mb-4" id="teamTabs" role="tablist">
        @foreach ($teamData as $role => $users)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ Str::slug($role, '-') }}-tab" 
                        data-bs-toggle="tab" data-bs-target="#{{ Str::slug($role, '-') }}" 
                        type="button" role="tab" aria-controls="{{ Str::slug($role, '-') }}" 
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    {{ $role }}
                </button>
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="teamTabsContent">
        @foreach ($teamData as $role => $users)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ Str::slug($role, '-') }}" 
                 role="tabpanel" aria-labelledby="{{ Str::slug($role, '-') }}-tab">
                <div class="row">
                    @foreach ($users as $user)
                        <div class="col-sm-12 col-md-2 mb-4" style="scale:.95">
                            <div class="team-item h-100 user-card">
                                <div class="team-img">
                                    <div class="team-img-efects">
                                        <img src="{{ $user['image'] }}" class="img-fluid w-100 rounded-top" alt="{{ $user['name'] }}">
                                    </div>
                                    <div class="team-icon rounded-pill p-2 d-flex justify-content-center align-items-center">
                                        <a class="btn btn-square btn-primary rounded-circle mx-1" href="{{ $user['facebook'] }}" target="_blank"><i class="bi bi-facebook"></i></a>
                                        <a class="btn btn-square btn-success rounded-circle mx-1" href="https://wa.me/{{ $user['whatsapp'] }}" target="_blank"><i class="bi bi-whatsapp"></i></a>
                                        <a class="btn btn-square btn-secondary rounded-circle mx-1" href="tel:{{ $user['mobile_number'] }}" target="_blank"><i class="bi bi-telephone"></i></a>
                                    </div>
                                </div>
                                <div class="team-title text-center rounded-bottom p-1 d-flex flex-column" style="overflow: hidden;">
                                    <div class="team-title-inner mb-auto">
                                        <h5 class="fs-6 mt-1 text-no-overflow">{{ $user['name'] }}</h5>
                                        <p class="mb-1 text-no-overflow">{{ $user['position'] }}</p>
                                    </div>
                                    <div class="flex m-2">
                                        <a href="{{ route('positions.details', ['uuid' => $user['uuid'] ]) }}" class="cw-btn"><i class="bi-eye"></i> View Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

    
</x-main-layout>
