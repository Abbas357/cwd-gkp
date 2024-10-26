<style>
    .modal-img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 15px;
}

.info-row {
    margin-bottom: 10px;
}

.info-label {
    font-weight: bold;
    width: 150px;
    display: inline-block;
}

.info-value {
    display: inline-block;
}

.document-link {
    color: #0d6efd;
    text-decoration: none;
}

.document-link:hover {
    text-decoration: underline;
}
</style>
<div class="text-center">
    <img src="{{ $user['media']['profile_pictures'] }}" class="modal-img" alt="{{ $user['name'] }}">
    <h4 class="mt-2">{{ $user['name'] }}</h4>
    <p>{{ $user['title'] }}</p>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        <!-- Personal Information -->
        <div class="info-row">
            <span class="info-label">CNIC:</span>
            <span class="info-value">{{ $user['cnic'] }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value">{{ $user['email'] }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Mobile Number:</span>
            <span class="info-value">{{ $user['mobile_number'] }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Landline Number:</span>
            <span class="info-value">{{ $user['landline_number'] }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">WhatsApp:</span>
            <span class="info-value"><a href="https://wa.me/{{ $user['whatsapp'] ?? '' }}" target="_blank">{{ $user['whatsapp'] }}</a></span></span>
        </div>
        <div class="info-row">
            <span class="info-label">Facebook:</span>
            <span class="info-value"><a href="https://facebook.com/{{ $user['facebook'] ?? '' }}" target="_blank">{{ $user['facebook'] }}</a></span>
        </div>
        <div class="info-row">
            <span class="info-label">Twitter:</span>
            <span class="info-value"> <a href="https://x.com/{{ $user['twitter'] }}" target="_blank">{{ $user['twitter'] }}</a></span>
        </div>
    </div>
    <div class="col-md-6">
        <!-- Professional Information -->
        <div class="info-row">
            <span class="info-label">Designation:</span>
            <span class="info-value">{{ $user['designation'] }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Posting Type:</span>
            <span class="info-value">{{ $user['posting_type'] }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Posting Date:</span>
            <span class="info-value">{{ $user['posting_date'] }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Exit Type:</span>
            <span class="info-value">{{ $user['exit_type'] }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Exit Date:</span>
            <span class="info-value">{{ $user['exit_date'] }}</span>
        </div>
        <!-- Posting and Exit Orders -->
        <div class="info-row">
            <span class="info-label">Posting Order:</span>
            <span class="info-value">
                @if($user['media']['posting_orders'])
                    <a href="{{ $user['media']['posting_orders'] }}" target="_blank" class="document-link">View Posting Order</a>
                @else
                    N/A
                @endif
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Exit Order:</span>
            <span class="info-value">
                @if($user['media']['exit_orders'])
                    <a href="{{ $user['media']['exit_orders'] }}" target="_blank" class="document-link">View Exit Order</a>
                @else
                    N/A
                @endif
            </span>
        </div>
    </div>
</div>
