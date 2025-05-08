<style>
    .contractor-card {
        border: 2px solid #ddd;
        border-radius: 10px;
        padding: .5rem;
        width: 380px;
        height: 240px;
        margin: auto;
        margin-bottom: .3rem
    }

    .contractor-card_front {
        background-image: url('{{ asset('admin/images/cards/contractor-card-front.png') }}?cw=42');
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
                font-size: 130%;
                font-weight: bolder;
                color: #ff0000;
            }
        }

        .main {
            position: absolute;
            top: 4.5rem;
            left: 8.6rem;
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
            left: 1rem;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 50%;

            img {
                display: inline-block;
                height: 115px;
                border: 5px solid transparent;
                border: 2px solid #aaa;
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
            white-space: nowrap;
            font-size: 65%;
        }

        .qr-code {
            position: absolute;
            bottom: 1.6rem;
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
            left: 5%;
            h1 {
                text-transform: uppercase;
                font-size: 1.1rem;
                margin: 0px;
                letter-spacing: 1px;
                white-space: nowrap;
                font-weight: bold;
                color: #fff;
                transform: scale(.7, 1);
            }
        }
        
    }

    .contractor-card_back {
        background-image: url('{{ asset('admin/images/cards/contractor-card-back.png') }}?cw=42');
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
            top: 2.4rem;
            width:94%;
        }
        .back-footer {
            position: absolute;
            bottom: .1rem;
            p {
                margin: 0px;
                color: #222;
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
    <div class="contractor-card contractor-card_front text-center">

        <div class="header-left">
            <img src="{{ asset('admin/images/logo-square.png') }}" alt="">
            <div class="tagline">
                <span>GOVERNMENT OF KHYBER PAKHTUNKHWA</span>
                <span>COMMUNICATION AND WORKS</span>
                <span>DEPARTMENT</span>
            </div>
        </div>

        <div class="header-right">
            <span class="expires">EXPIRES: {{ $contractor_registration->getLatestCard()->expiry_date->format('j, M Y'); }}</span>
        </div>

        <div class="image">
            <img src="{{ $contractor_registration->contractor->getFirstMediaUrl('contractor_pictures') ?: asset('admin/images/no-profile.png') }}" alt="{{ $contractor_registration->contractor->firm_name }}">
        </div>

        <div class="main">
            <h1>{{ $contractor_registration->contractor->firm_name }}</h1>
            <h2> {{ $contractor_registration->category_applied }} / {{ $contractor_registration->pec_number }}</h2>
            <h3> Name: {{ $contractor_registration->contractor->name }}</h3>
        </div>

        <div class="footer">
            <div class="sign">
                <img src="{{ asset('admin/images/cards/service-card-sign.png') }}" alt="Sign">
            </div>
            <div class="authority-sign">
                ADDL. SECRETARY (TECH.)
            </div>
            <div class="qr-code">
                <img src="{{ $qrCodeUri }}" style="width: 75px;border:3px solid transparent; outline: 2px solid #aaa" alt="QR Code for verification">
            </div>
        </div>

        <div class="bottom-text">
            <h1>Contractor Registration Card</h1>
        </div>

    </div>

    <!-- Back Side -->
    <div class="card contractor-card contractor-card_back">
        <div class="mx-1 mt-5">
            <div class="back-heading">
                <h1>Contractor Detail</h1>
            </div>

            <div class="back-main">
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-secondary">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold">CNIC: &emsp;</div>
                        <div>{{ $contractor_registration->contractor->cnic }}</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center ml-auto">
                        <div class="fw-bold">Issue Date: &emsp;</div>
                        <div>{{ $contractor_registration->getLatestCard()->issue_date->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-secondary">
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="fw-bold">District: &emsp;</div>
                        <div>{{ $contractor_registration->contractor->district }}</div>
                    </div>
                    <div class="d-flex justify-content-around align-items-center ml-auto">
                        <div class="fw-bold">Registration No: &emsp;</div>
                        <div>{{ $contractor_registration->reg_number }}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-secondary">
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="fw-bold">Email: &emsp;</div>
                        <div style="overflow: hidden; text-overflow: ellipsis;">{{ $contractor_registration->contractor->email }}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-secondary">
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="fw-bold">Mobile Number: &emsp;</div>
                        <div style="overflow: hidden; text-overflow: ellipsis;">{{ $contractor_registration->contractor->mobile_number }}</div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-start align-items-center pt-1 mb-1 border-bottom border-secondary">
                    <div class="fw-bold">Address: &emsp;</div>
                    <div style="overflow: hidden; text-overflow: ellipsis;">{{ $contractor_registration->contractor->address }}</div>
                </div>
            </div>
            
            <div class="back-footer">
                <p class="text-danger fw-bold">Note: Cardholder is an approved contractor, not a government official.</p>
                <p>
                    Issued by Communication and Works Department Govt. of Khyber Pakhtunkhwa.<br />
                    For Verification, scan QR code or contact IT Cell (9214039), C&W Department. <br />
                    If found please drop into the nearest letter box.
                </p>
            </div>
        </div>

    </div>

</div>
