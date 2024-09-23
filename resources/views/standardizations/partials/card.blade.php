<x-guest-layout>
    @push('style')
    <style>
        .custom-card {
            border: 2px solid #007bff;
            border-radius: 15px;
            padding: 20px;
            max-width: 400px;
            margin: auto;
        }

        .custom-card img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }

        .custom-card .signature {
            margin-top: 20px;
            font-family: 'Cursive';
        }

        .custom-card .authority-sign {
            border-top: 1px solid black;
            width: 150px;
            margin-top: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .terms {
            font-size: 12px;
        }

    </style>
    @endpush
    <div class="row">
        <!-- Front Side -->
        <div class="card custom-card text-center">
            <h5 class="card-title">Government Of Khyber Pukhtunkhwa</h5>
            <h6 class="card-subtitle mb-2 text-muted">E-Registration Of Engineering Product</h6>
            <img src="https://via.placeholder.com/100" alt="User Avatar">
            <h6>M/S Jamal Pipe Industries (PVT) Ltd</h6>
            <p>Product: Steel line pipe Size = 1/2 to 24"</p>
            <p class="text-danger">This certificate is valid for three years from the date of issue</p>
            <div class="signature">
                {{ $EStandardization->product_name }}
            </div>
            <div class="authority-sign">
                Authority Sign
            </div>
            <p>Date: 22-DEC-2023</p>
            <img src="https://via.placeholder.com/50x50" alt="QR Code">
        </div>

        <!-- Back Side -->
        <div class="card custom-card">
            <h5 class="card-title text-center">Terms and Conditions</h5>
            <div class="terms">
                <ol>
                    <li>The manufacturer authorized dealers will be bound to issue sales tax invoice for each consignment supplied to the contractor with the name of purchaser and name of work.</li>
                    <li>The firm will be bound to provide test reports (along with other documents) of the product supplied on the request of concerned Divisional officer of PHED/concerned department Khyber Pakhtunkhwa.</li>
                    <li>For Pipe, each pipe will bear the stamp of the manufacturer with pipe classification, identification code as per international standard specifications.</li>
                    <li>The firm will be responsible for the quality of the product supplied to the contractor.</li>
                    <li>Unsatisfactory performance and below specification product supplied to contractors will result in legal action, rejection of material supplied and blacklisting of the firm.</li>
                </ol>
            </div>
        </div>
    </div>
</x-guest-layout>
