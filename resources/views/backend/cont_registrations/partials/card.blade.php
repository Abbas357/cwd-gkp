<div id="capture">
    <div class="contractor-card contractor-card_front text-center">
        <div class="d-flex justify-content-between align-items-center">
            <img src="{{ asset('images/logo-square.png') }}" class="logo" alt="KP Logo">
            <div class="header">
                <h1>Communication & Works Department</h1>
                <h3>Civil Secretariat, Peshawar</h3>
            </div>
        </div>

        <h6 class="card-main-title">Contractor Registration Card</h6>

        <div class="d-flex align-items-center gap-3 mt-4">
            <img src="{{ getProfilePic(auth()->user()) }}" class="company-logo" alt="Contractor Name">
            <div class="body align-self-start mt-3 ml-5">
                <h5>{{ $ContractorRegistration->contractor_name }}</h5>
                <p> Enlistment No: {{ $ContractorRegistration->pec_number }} </p>
            </div>
        </div>
        

        <div class="footer">
            <div></div>
            <div class="authority-sign align-self-end">
                Addl. Secretary (Tech)
            </div>
            <div>
                <p style="font-size: 10px; margin-bottom:0px; color:red">Validity: {{ $ContractorRegistration->updated_at->format('d-M-Y') }}</p>
                <img src="{{ $qrCodeUri }}" style="width: 80px" alt="QR Code for verification">
            </div>
        </div>
    </div>

    <!-- Back Side -->
    <div class="card contractor-card contractor-card_back mt-1">
        <h5 class="card-main-title">Contractor Details</h5>
        <table>
            <tbody>
                <tr>
                    <th>Firm Name</th>
                    <td>{{ $ContractorRegistration->contractor_name }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $ContractorRegistration->address }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $ContractorRegistration->email }}</td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <td>{{ $ContractorRegistration->mobile_number }}</td>
                </tr>
                <tr>
                    <th>Issue Date</th>
                    <td>{{ $ContractorRegistration->created_at->format('d-M-Y') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Issued by IT Section, C&W Department, Khyber Pakhtunkhwa</p>
        </div>
    </div>
</div>
