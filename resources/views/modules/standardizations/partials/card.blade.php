<style>
    .product-card {
        border: 2px solid #ddd;
        border-radius: 10px;
        padding: .5rem;
        width: 380px;
        height: 240px;
        margin: auto;
        margin-bottom: .3rem
    }

    .product-card_front {
        background-image: url('{{ asset('admin/images/cards/product-card-front.png') }}?cw=30');
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
                border: 2px solid #ccc;
                border-radius: 5px;
            }
        }

        .authority-sign {
            position: absolute;
            bottom: 1.5rem;
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
            bottom: 1.8rem;
            right: .3rem;
        }

        .sign {
            position: absolute;
            bottom: 1.8rem;
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

    .product-card_back {
        background-image: url('{{ asset('admin/images/cards/product-card-back.png') }}?cw=30');
        background-size: cover;
        background-repeat: no-repeat;
        position: relative;
        font-size: 11px;

        .back-heading {
            position: absolute;
            top: .1rem;
            left: 15%;

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
            top: 1.9rem;
            width:94%;
            text-align: justify;
            font-size: 10px;
            line-height: .75rem;
            color: #222;
        }
        .back-footer {
            position: absolute;
            bottom: 0px;
            left: .4rem;
            p {
                margin: 0px;
                color: #575757;
                text-align: center;
                font-size: 10px;
                font-weight:normal;
            }
        }
    }

    .ml-auto {
        margin-left: auto
    }


</style>

<div id="capture">
    <div class="product-card product-card_front text-center">

        <div class="header-left">
            <img src="{{ asset('admin/images/logo-square.png') }}" alt="">
            <div class="tagline">
                <span>GOVERNMENT OF KHYBER PAKHTUNKHWA</span>
                <span>COMMUNICATION AND WORKS</span>
                <span>DEPARTMENT</span>
            </div>
        </div>

        <div class="header-right">
            <span class="expires">EXPIRES: {{ $Standardization->getLatestCard()->expiry_date->format('j, M Y'); }}</span>
        </div>

        <div class="image">
            <img src="{{ $Standardization->getFirstMediaUrl('standardization_firms_pictures') ?: asset('admin/images/no-profile.png') }}" alt="{{ $Standardization->product_name }}">
        </div>

        <div class="main">
            <h1>{{ $Standardization->firm_name }}</h1>
            <h2> {{ $Standardization->name }}</h2>
            <h3>Products</h3>
            @foreach($Standardization->products as $product)
                <div>{{ $product->name }}</div>
            @endforeach
        </div>

        <div class="footer">
            <div class="sign">
                <img src="{{ asset('admin/images/cards/service-card-sign.png') }}" alt="Sign">
            </div>
            <div class="authority-sign">
                ISSUING AUTHORITY
            </div>
            <div class="qr-code">
                <img src="{{ $qrCodeUri }}" style="width: 75px;border:3px solid transparent; outline: 2px solid #aaa" alt="QR Code for verification">
            </div>
        </div>

        <div class="bottom-text">
            <h1>Product Standardization Card</h1>
        </div>

    </div>

    <!-- Back Side -->
    <div class="card product-card product-card_back">
        <div class="mx-1 mt-5">
            <div class="back-heading">
                <h1>Terms and Conditions</h1>
            </div>

            <div class="back-main">
                <div class="d-flex justify-content-start align-items-center border-bottom border-secondary">
                    1. The manufacturer authorized dealers will be bound to issue sales tax invoice for each consignment supplied to the contractor with the name of purchaser and name of work.
                </div>
                <div class="d-flex justify-content-start align-items-center border-bottom border-secondary">
                    2. The firm will be bound to provide test reports (along with other documents) of the product supplied on the request of concerned Divisional officer of PHED/concerned department Khyber Pakhtunkhwa.
                </div>
                <div class="d-flex justify-content-start align-items-center border-bottom border-secondary">
                    3. For Pipe, each pipe will bear the stamp of the manufacturer with pipe classification, identification code as per international standard specifications.
                </div>
                <div class="d-flex justify-content-start align-items-center border-bottom border-secondary">
                    4. The firm will be responsible for the quality of the product supplied to the contractor.
                </div>
                <div class="d-flex justify-content-start align-items-center border-bottom border-secondary">
                    5. Unsatisfactory performance and below specification product supplied to contractors will result in legal action, rejection of material supplied and blacklisting of the firm.
                </div>
            </div>
            
            <div class="back-footer">
                <p class="text-danger" style="white-space: nowrap"><strong>Note: Cardholder is a Standardized Firm, not a government entity.</strong></p>
                <p>
                    Issued by IT Cell, C&W Department Govt. of Khyber Pakhtunkhwa.<br />
                </p>
            </div>
        </div>

    </div>

</div>
