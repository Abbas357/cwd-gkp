<style>
    .service-card {
        border: 2px solid #ddd;
        border-radius: 10px;
        padding: .5rem;
        width: 380px;
        height: 240px;
        margin: auto;
        margin-bottom: .3rem
    }

    .service-card_front {
        background-image: url('{{ asset('admin/images/cards/service-card-front.png') }}?cw=24');
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

        .header-right {
            position: absolute;
            top: 2.5rem;
            right: .2rem;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 50%;

            span {
                text-align: right;
                display: block;
            }

            .expires {
                font-size: 120%;
                font-weight: bolder;
                color: #ff0000;
            }
        }

        .main {
            position: absolute;
            top: 4.5rem;
            left: 8.2rem;
            text-transform: uppercase;
            text-align: left;

            h1 {
                font-weight: bold;
                font-size: 1rem;
                margin-bottom: 2px;
            }

            h2 {
                font-size: .7rem;
                font-weight: bold;
                margin-bottom: 1rem;
            }

            h3 {
                font-size: .7rem;
                font-weight: bold;
            }
        }

        .image {
            position: absolute;
            top: 4.5rem;
            left: 1.1rem;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 50%;

            img {
                display: inline-block;
                height: 115px;
                width: 100px;
                border: 5px solid transparent;
                border: 2px solid #ccc;
                border-radius: 5px;
            }
        }

        .authority-sign {
            position: absolute;
            bottom: 1.3rem;
            left: 7rem;
            border-top: 1px solid black;
            width: 130px;
            text-align: center;
            margin-right: 3rem;
            font-size: 75%;
        }

        .qr-code {
            position: absolute;
            bottom: 1.5rem;
            right: .3rem;
        }

        .sign {
            position: absolute;
            bottom: 1.5rem;
            left: 8.5rem;
            width: 30px;
            rotate: -30deg;

            img {
                width: 100px;
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
        background-image: url('{{ asset('admin/images/cards/service-card-back.png') }}?cw=24');
        background-size: cover;
        background-repeat: no-repeat;
        position: relative;
        font-size: 11px;

        .back-heading {
            position: absolute;
            top: .7rem;
            left: 20%;

            h1 {
                text-transform: uppercase;
                font-size: 1.2rem;
                color: #555;
                letter-spacing: 1px;
                border-bottom: 2px solid #555;
                font-weight: bold;
                transform: scale(.7, 1);
            }
        }
        .back-main {
            position: absolute;
            top: 3rem;
            width:94%;
        }
        .back-footer {
            position: absolute;
            bottom: 0;
            p {
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

        <div class="header-left">
            <img src="{{ asset('admin/images/logo-square.png') }}" alt="">
            <div class="tagline">
                <span>GOVERNMENT OF KHYBER PAKHTUNKHWA</span>
                <span>COMMUNICATION AND WORKS</span>
                <span>DEPARTMENT</span>
            </div>
        </div>

        <div class="header-right">
            <span class="expires">EXPIRES: {{ $ServiceCard->getLatestCard()->expiry_date->format('j, M Y'); }}</span>
        </div>

        <div class="image">
            <img src="{{ $ServiceCard->getFirstMediaUrl('service_card_pictures') ?? '' }}" alt="{{ $ServiceCard->name }}">
        </div>

        <div class="main">
            <h1>{{ $ServiceCard->name }}</h1>
            <h2> {{ $ServiceCard->designation }}</h2>
            <h3> OFFICE: {{ $ServiceCard->office }}</h3>
        </div>

        <div class="footer">
            <div class="sign">
                <img src="{{ asset('admin/images/cards/service-card-sign.png') }}" alt="Sign">
            </div>
            <div class="authority-sign">
                ISSUING AUTHORITY
            </div>
            <div class="qr-code">
                <img src="{!! $qrCodeUri !!}" style="width: 75px;border:3px solid transparent; outline: 2px solid #aaa" alt="QR Code for verification">
            </div>
        </div>

        <div class="bottom-text">
            <h1>Service Identity Card</h1>
        </div>

    </div>

    <!-- Back Side -->
    <div class="card service-card service-card_back">
        <div class="mx-1 mt-5">
            <div class="back-heading">
                <h1>Employee Detail</h1>
            </div>

            <div class="back-main">
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-secondary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold">Personnel No: &emsp;</div>
                        <div>{{ $ServiceCard->personnel_number }}</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center ml-auto">
                        <div class="fw-bold">Issue Date: &emsp;</div>
                        <div>{{ $ServiceCard->getLatestCard()->issue_date->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-secondary">
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="fw-bold">Father Name: &emsp;</div>
                        <div>{{ $ServiceCard->father_name }}</div>
                    </div>
                    <div class="d-flex justify-content-around align-items-center ml-auto">
                        <div class="fw-bold">Blood Group: &emsp;</div>
                        <div>{{ $ServiceCard->blood_group }}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-secondary">
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="fw-bold">Date of Birth: &emsp;</div>
                        <div>{{ $ServiceCard->date_of_birth->format('d/m/Y') }}</div>
                    </div>
                    <div class="d-flex justify-content-around align-items-center ml-auto">
                        <div class="fw-bold">Identification Mark: &emsp;</div>
                        <div style="overflow: hidden; text-overflow: ellipsis;">{{ $ServiceCard->mark_of_identification }}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-secondary">
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="fw-bold">CNIC: &emsp;</div>
                        <div style="overflow: hidden; text-overflow: ellipsis;">{{ $ServiceCard->cnic }}</div>
                    </div>
                    <div class="d-flex justify-content-around align-items-center ml-auto">
                        <div class="fw-bold">Emergency #: &emsp;</div>
                        <div style="overflow: hidden; text-overflow: ellipsis;">{{ $ServiceCard->emergency_contact }}</div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-secondary">
                    <div class="fw-bold">Present Address: &emsp;</div>
                    <div style="overflow: hidden; text-overflow: ellipsis;">{{ $ServiceCard->present_address }}</div>
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
