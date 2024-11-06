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

a i:hover {
    filter: contrast(130%) brightness(130%) drop-shadow(7px 7px 3px #ccc)
}
</style>
<div class="text-center">
    <img src="{{ $user['media']['profile_pictures'] }}" class="modal-img" alt="{{ $user['name'] }}">
    <h4 class="mt-2">{{ $user['name'] }}</h4>
    <p>{{ $user['title'] }}</p>
</div>
<div class="text-center">
    <a href="https://facebook.com/{{ $user['facebook'] ?? '#' }}"><i class="bi bi-facebook fs-1 me-2" style="color: #3b5998"></i></a>
    <a href="https://x.com/{{ $user['twitter'] ?? '#' }}"><i class="bi bi-twitter fs-1 me-2" style="color: #1da1f2"></i></a>
    <a href="https://wa.me/{{ $user['whatsapp'] ?? '#' }}"><i class="bi bi-whatsapp fs-1 me-2" style="color: #25d366"></i> </a>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        <div class="info-row">
            <span class="info-label">Designation:</span>
            <span class="info-value">{{ $user['designation'] }}</span>
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
    </div>
    <div class="col-md-6">
        @if($user['is_active'])
        <div class="info-row">
            <span class="info-label">Posting Type:</span>
            <span class="info-value">{{ $user['posting_type'] }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Posting Date:</span>
            <span class="info-value">{{ $user['posting_date'] }}</span>
        </div>
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
        @else
        <div class="info-row">
            <span class="info-label">Exit Type:</span>
            <span class="info-value">{{ $user['exit_type'] }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Exit Date:</span>
            <span class="info-value">{{ $user['exit_date'] }}</span>
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
        @endif        
        
    </div>
</div>
