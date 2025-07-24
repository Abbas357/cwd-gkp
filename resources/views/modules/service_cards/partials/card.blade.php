@php
    $user = $ServiceCard->user;
    $profile = $user->profile;
@endphp

<style>
    .service-card {
        width: 380px;
        height: 240px;
        margin: auto;
    }

    .service-card_front {
        background-image: url('{{ asset('admin/images/cards/service-card-front.png') }}?cw=70');
        background-size: cover;
        background-repeat: no-repeat;
        position: relative;

        .header-left {
            position: absolute;
            top: .3rem;
            left: .3rem;
            
            img {
                position: absolute;
                top:0;
                left:0;
                width: 50px;
            }

            .tagline {
                position: absolute;
                top:-4px;
                left:-4px;
                font-weight: bold;
                span {
                    white-space: nowrap;
                    display: block;
                    margin-bottom: -6px;
                    font-weight: bolder;
                    transform: scale(.7, 1);
                    font-size: 13px;
                    letter-spacing: 1px;
                    text-shadow: 1px 1px 3px #fff, -1px -1px 3px #fff;
                }
            }

        }

        .expired-at {
            position: absolute;
            bottom: 6rem;
            right: .2rem;
            text-transform: uppercase;

            span {
                text-align: right;
                display: block;
                font-size: 6px;
                font-weight: bolder;
                color: #ff0000;
            }
        }

        .main {
            position: absolute;
            top: 5rem;
            left: 7.5rem;
            text-transform: uppercase;
            text-align: left;

            h1 {
                font-weight: bold;
                font-size: 1rem;
                margin-bottom: 3px;
            }

            h2 {
                font-size: .7rem;
                font-weight: bold;
                margin-bottom: .5rem;
            }

            h3 {
                font-size: .6rem;
                font-weight: bold;
            }
        }

        .image {
            position: absolute;
            top: 5rem;
            left: 1.1rem;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 50%;

            img {
                display: inline-block;
                height: 100px;
                width: 90px;
                border: 5px solid transparent;
                border: 1px solid #000;
                border-radius: 5px;
            }
        }

        .authority-sign {
            position: absolute;
            bottom: 1.3rem;
            left: 1rem;
            width: 130px;
            text-align: center;
            margin-right: 3rem;
            font-size: 75%;
        }

        .qr-code {
            position: absolute;
            bottom: 1.3rem;
            right: .3rem;
        }

        .sign {
            position: absolute;
            bottom: .8rem;
            left: 1rem;
            width: 30px;

            img {
                width: 70px;
            }
        }

        .bottom-text {
            position: absolute;
            bottom: -1px;
            left: 17%;
            h1 {
                text-transform: uppercase;
                font-size: 1.1rem;
                margin: 0px;
                letter-spacing: 1px;
                font-weight: bold;
                color: #fff;
                transform: scale(.7, 1);
            }
        }
        
    }

    .service-card_back {
        background-image: url('{{ asset('admin/images/cards/service-card-back.png') }}?cw=70');
        background-size: cover;
        background-repeat: no-repeat;
        position: relative;
        font-size: 11px;

        .back-main {
            position: absolute;
            top: 1rem;
            left: .7rem;
            width: 94%;
        }
        .back-footer {
            position: absolute;
            bottom: 1.7rem;
            left: .7rem;
            p {
                border-top: 3px solid #ddd;
                margin: 0px;
                color: #575757;
                text-align: center;
                font-size: 9px;
                font-weight:normal;
            }
        }
    }

    .ml-auto {
        margin-left: auto
    }
</style>

<div id="capture">
    <div class="service-card service-card_front text-center">

        <div class="image">
            <img src="{{ $user->getFirstMediaUrl('profile_pictures') ?: asset('admin/images/default-avatar.png') }}" alt="{{ $user->name }}">
        </div>

        <div class="main">
            <h1>{{ $user->name }}</h1>
            <h2>{{ $user->currentDesignation ? $user->currentDesignation->name : 'N/A' }}</h2>
            <h3>OFFICE: {{ $user->currentOffice ? $user->currentOffice->name : 'N/A' }}</h3>
        </div>

        <div class="footer">
            <div class="sign">
                <img src="{{ asset('admin/images/cards/service-card-sign.png') }}?cw=70" alt="Sign">
            </div>

            <div class="authority-sign">
            </div>

            <div class="expired-at">
                <span>EXPIRES: {{ $ServiceCard->expired_at ? $ServiceCard->expired_at->format('j, M Y') : 'N/A' }}</span>
            </div>
            <div class="qr-code">
                <img src="{!! $qrCodeUri !!}" style="width: 75px;border:3px solid transparent; outline: 2px solid #aaa" alt="QR Code for verification">
            </div>
        </div>

        <div class="bottom-text">
        </div>

    </div>

    <!-- Back Side -->
    <div class="card service-card service-card_back">
        <div class="mx-1 mt-1">

            <div class="back-main">
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-2 border-secondary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold">Personnel No: &emsp;</div>
                        <div>{{ $profile->personnel_number ?? 'N/A' }}</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center ml-auto">
                        <div class="fw-bold">Issue Date: &emsp;</div>
                        <div>{{ $ServiceCard->issued_at ? $ServiceCard->issued_at->format('d/m/Y') : 'N/A' }}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-2 border-secondary">
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="fw-bold">Father Name: &emsp;</div>
                        <div>{{ $profile->father_name ?? 'N/A' }}</div>
                    </div>
                    <div class="d-flex justify-content-around align-items-center ml-auto">
                        <div class="fw-bold">Blood Group: &emsp;</div>
                        <div>{{ $profile->blood_group ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-2 border-secondary">
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="fw-bold">Date of Birth: &emsp;</div>
                        <div>{{ $profile->date_of_birth ? $profile->date_of_birth->format('d/m/Y') : 'N/A' }}</div>
                    </div>
                    <div class="d-flex justify-content-around align-items-center ml-auto">
                        <div class="fw-bold">Identification Mark: &emsp;</div>
                        <div style="overflow: hidden; text-overflow: ellipsis;">{{ $profile->mark_of_identification ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-2 border-secondary">
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="fw-bold">CNIC: &emsp;</div>
                        <div style="overflow: hidden; text-overflow: ellipsis;">{{ $profile->cnic ?? 'N/A' }}</div>
                    </div>
                    <div class="d-flex justify-content-around align-items-center ml-auto">
                        <div class="fw-bold">Emergency #: &emsp;</div>
                        <div style="overflow: hidden; text-overflow: ellipsis;">{{ $profile->emergency_contact ?? 'N/A' }}</div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-2 border-secondary">
                    <div class="fw-bold">Present Address: &emsp;</div>
                    <div style="overflow: hidden; text-overflow: ellipsis;">{{ $profile->present_address ?? 'N/A' }}</div>
                </div>
            </div>
            
            <div class="back-footer">
                <p>
                    Issued by Communication and Works Department Govt. of Khyber Pakhtunkhwa.<br />
                    For Verification, scan QR code or contact IT Cell (9214039), C&W Department. <br />
                    If found please drop into the nearest letter box.
                </p>
            </div>
        </div>

    </div>

</div>