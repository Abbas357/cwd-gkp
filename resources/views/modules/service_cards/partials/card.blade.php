@php
    $user = $ServiceCard->user;
    $profile = $user->profile;
@endphp

<style>
    .service-card {
        width: 380px;
        height: 240px;
        margin: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
        position: relative;
        color: #000;
    }

    .expired-card,
    .lost-card {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 50%;
        height: 50%;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        transform: translate(-50%, -50%) rotate(-30deg);
        z-index: 999;
        opacity: 0.5;
        pointer-events: none;
    }


    .service-card_front {
        position: relative;
    }

    .service-card_front .background-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        object-fit: cover;
    }

    /* .service-card_front .header-left {
        position: absolute;
        top: .3rem;
        left: .3rem;
        z-index: 10;
    }

    .service-card_front .header-left img {
        position: absolute;
        top: 0;
        left: 0;
        width: 50px;
    }

    .service-card_front .header-left .tagline {
        position: absolute;
        top: -4px;
        left: -4px;
        font-weight: bold;
    }

    .service-card_front .header-left .tagline span {
        white-space: nowrap;
        display: block;
        margin-bottom: -6px;
        font-weight: bolder;
        transform: scale(.7, 1);
        font-size: 13px;
        letter-spacing: 1px;
        text-shadow: 1px 1px 3px #fff, -1px -1px 3px #fff;
    } */

    .service-card_front .expired-at {
        position: absolute;
        top: 2.8rem;
        right: .8rem;
        text-transform: uppercase;
        z-index: 10;
    }

    .service-card_front .expired-at span {
        text-align: right;
        display: block;
        font-weight: bold;
        font-size: 8px;
        color: #ff0000;
        border-bottom: 1px solid #ff0000;
        line-height: 1;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .service-card_front .main {
        position: absolute;
        top: 6.2rem;
        left: 7.2rem;
        text-transform: uppercase;
        text-align: left;
        z-index: 10;
    }

    .service-card_front .main h1 {
        font-weight: bold;
        font-size: .9rem;
        margin-bottom: 3px;
        width: 183px;
    }

    .service-card_front .main h2 {
        font-size: .7rem;
        font-weight: bold;
        margin-bottom: .9rem;
        width: 250px;
    }

    .service-card_front .main h3 {
        font-size: .6rem;
        font-weight: bold;
        width: 250px;
    }

    .service-card_front .image {
        position: absolute;
        top: 6rem;
        left: 1rem;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 50%;
        z-index: 10;
    }

    .service-card_front .image img {
        display: inline-block;
        height: 90px;
        width: 82px;
        border: 5px solid transparent;
        border: 1px solid #000;
        border-radius: 5px;
    }

    .service-card_front .authority-sign {
        position: absolute;
        bottom: 1.3rem;
        left: 1rem;
        width: 130px;
        text-align: center;
        margin-right: 3rem;
        font-size: 75%;
        z-index: 10;
    }

    .service-card_front .qr-code {
        position: absolute;
        top: 3.7rem;
        right: .78rem;
        z-index: 10;
    }

    .service-card_front .qr-code img {
        width: 67px;
        padding: 2px;
        border: 1px solid #000;
    }

    .service-card_front .sign {
        position: absolute;
        bottom: 1.6rem;
        left: 1rem;
        width: 30px;
        z-index: 10;
    }

    .service-card_front .sign img {
        width: 70px;
        filter:
            drop-shadow(0px 0px 0 rgba(255, 255, 255, 0.9))
    }

    .service-card_front .bottom-text {
        position: absolute;
        bottom: -1px;
        left: 17%;
        z-index: 10;
    }

    .service-card_front .bottom h1 {
        text-transform: uppercase;
        font-size: 1.1rem;
        margin: 0px;
        letter-spacing: 1px;
        font-weight: bold;
        color: #fff;
        transform: scale(.7, 1);
    }

    .service-card_back {
        position: relative;
        font-size: 11px;
    }

    .service-card_back .background-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        object-fit: cover;
    }

    .service-card_back .back-main {
        position: absolute;
        top: .3rem;
        left: .7rem;
        width: 94%;
        z-index: 10;
    }

    .service-card_back .back-main .info-row {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        padding-top: 0.15rem;
        margin-bottom: 0.25rem;
        border-bottom: 2px solid #000;
    }

    .service-card_back .back-footer {
        position: absolute;
        bottom: 1.7rem;
        left: .7rem;
        z-index: 10;
    }

    .service-card_back .back-footer p {
        border-bottom: 2px solid #000;
        margin: 0px;
        color: #444;
        text-align: center;
        font-size: 9px;
        font-weight: normal;
    }

    .ml-auto {
        margin-left: auto
    }
</style>

<div id="capture">
    <div class="service-card service-card_front text-center">

        @if($ServiceCard->status === 'lost')
            <div class="lost-card" style="background-image: url('{{ asset('admin/images/cards/lost.png') }}');"></div>
        @endif
        @if($ServiceCard->status === 'expired')
            <div class="expired-card" style="background-image: url('{{ asset('admin/images/cards/expired.png') }}');"></div>
        @endif

        <img src="{{ asset('admin/images/cards/service-card-front.png') }}?cw=76" alt="Service Card Front"
            class="background-image">

        <div class="image">
            <img src="{{ getProfilePic($user) }}" alt="{{ $user->name }}">
        </div>

        {{-- <div class="header-left">
            <img src="{{ asset('admin/images/logo-square.png') }}" alt="">
            <div class="tagline">
                <span>GOVERNMENT OF KHYBER PAKHTUNKHWA</span>
                <span>COMMUNICATION AND WORKS</span>
                <span>DEPARTMENT</span>
            </div>
        </div> --}}

        <div class="main">
            <h1>{{ $user->name }}</h1>
            <h2>{{ $user->currentDesignation ? $user->currentDesignation->name : 'N/A' }}</h2>
            <h3>OFFICE: {{ $user->currentOffice ? $user->currentOffice->name : 'N/A' }}</h3>
        </div>

        <div class="footer">
            <div class="sign">
                <img src="{{ asset('admin/images/cards/service-card-sign.png') }}?cw=76" alt="Sign">
            </div>

            <div class="authority-sign">
            </div>

            <div class="expired-at">
                <span>EXPIRES: {{ $ServiceCard->expired_at ? $ServiceCard->expired_at->format('j, M Y') : 'N/A' }}</span>
            </div>
            <div class="qr-code">
                <img src="{!! $qrCodeUri !!}" alt="QR Code for verification">
            </div>
        </div>

        <div class="bottom-text">
        </div>
    </div>

    <!-- Back Side -->
    <div class="card service-card service-card_back">

        @if($ServiceCard->status === 'lost')
            <div class="lost-card" style="background-image: url('{{ asset('admin/images/cards/lost.png') }}');"></div>
        @endif
        @if($ServiceCard->status === 'expired')
            <div class="expired-card" style="background-image: url('{{ asset('admin/images/cards/expired.png') }}');"></div>
        @endif
        
        <img src="{{ asset('admin/images/cards/service-card-back.png') }}?cw=76" alt="Service Card Back"
            class="background-image">

        <div class="mx-1 mt-1">
            <div class="back-main">
                <div class="info-row">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold">Personnel No: &emsp;</div>
                        <div>{{ $profile->personnel_number ?? 'N/A' }}</div>
                    </div> 
                    <div class="d-flex justify-content-between align-items-center ml-auto">
                        <div class="fw-bold">Issue Date: &emsp;</div>
                        <div>{{ $ServiceCard->issued_at ? $ServiceCard->issued_at->format('d/m/Y') : 'N/A' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold">Father Name: &emsp;</div>
                        <div>{{ $profile->father_name ?? 'N/A' }}</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center ml-auto">
                        <div class="fw-bold">Card #: &emsp;</div>
                        <div>{{ format_card_id($ServiceCard->id) }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold">Date of Birth: &emsp;</div>
                        <div>{{ $profile->date_of_birth ? $profile->date_of_birth->format('d/m/Y') : 'N/A' }}</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center ml-auto">
                        <div class="fw-bold">Blood Group: &emsp;</div>
                        <div>{{ $profile->blood_group ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold">CNIC: &emsp;</div>
                        <div style="overflow: hidden; text-overflow: ellipsis;">{{ $profile->cnic ?? 'N/A' }}</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center ml-auto">
                        <div class="fw-bold">Emergency #: &emsp;</div>
                        <div style="overflow: hidden; text-overflow: ellipsis;">
                            {{ $profile->emergency_contact ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="fw-bold">Identification Mark: &emsp;</div>
                        <div style="overflow: hidden; text-overflow: ellipsis;">
                            {{ $profile->mark_of_identification ?? 'Nil' }}</div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="fw-bold">Present Address: &emsp;</div>
                    <div style="overflow: hidden; text-overflow: ellipsis;">{{ $profile->present_address ?? 'N/A' }}
                    </div>
                </div>
            </div>

            <div class="back-footer">
                <p>
                    Issued by Communication and Works Department Govt. of Khyber Pakhtunkhwa.<br />
                    For Verification, scan QR code or contact IT Cell (091-9214039). <br />
                    If found please drop into the nearest letter box.
                </p>
            </div>
        </div>
    </div>
</div>
