<div id="capture">
    <div class="card contractor-card contractor-card_front text-center">
        <div class="d-flex justify-content-between align-items-center">
            <img src="{{ asset('images/logo-square.png') }}" class="logo" alt="KP Logo">
            <div>
                <h1 class="card-title">Government of Khyber Pakhtunkhwa</h5>
                <h1 class="card-title">Communication & Works Department</h5>
            </div>
        </div>
        <h6 class="card-subtitle text-muted lead">E-Registration of Engineering Products</h6>
        
        <img src="{{ getProfilePic(auth()->user()) }}" class="company-logo" alt="KP Logo">

        <h2 class="text-center">{{ $ContractorRegistration->owner_name }}</h2>
        <table class="text-start fs-6 mx-auto mb-5" style="width: 300px">
            <tr>
                <td>Firm Name</td>
                <td>{{ $ContractorRegistration->contractor_name }}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>{{ $ContractorRegistration->address }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $ContractorRegistration->email }}</td>
            </tr>
            <tr>
                <td>Contact Number</td>
                <td>{{ $ContractorRegistration->mobile_number }}</td>
            </tr>
            <tr>
                <td>Issue Date</td>
                <td>{{ $ContractorRegistration->created_at->format('d-M-Y') }}</td>
            </tr>
        </table>
        <p class="text-danger">This certificate is valid for three years from the date of issue</p>
        

        <div class="d-flex justify-content-between align-items-center">
            <div class="authority-sign align-self-end">
                Authority Sign
            </div>
            <div>
                <p style="font-size: 10px; margin-bottom:0px">Date: {{ $ContractorRegistration->updated_at->format('d-M-Y') }}</p>
                <img src="{{ $qrCodeUri }}" style="width: 100px" alt="QR Code for verification">
            </div>
        </div>
    </div>

    <!-- Back Side -->
    <div class="card contractor-card contractor-card_back mt-1">
        <img src="{{ asset('images/logo-square.png') }}" class="logo block mx-auto" alt="KP Logo">
        <h5 class="card-title text-center mt-2">Terms and Conditions</h5>
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
