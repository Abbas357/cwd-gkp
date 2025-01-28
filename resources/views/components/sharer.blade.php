<div class="container mt-4">
    <div class="sharer-container">
        <h5 class="m-0 text-secondary d-flex align-items-center"><i class="bi-share-fill text-primary fs-2 me-2"></i> &nbsp; <span class="d-none d-xl-inline-block">Share this</span> &nbsp; </h5>
        <div class="sharer-button" data-sharer="email" data-title="{{ $title }}" data-url="{{ $url }}">
            <i class="bi bi-envelope-fill"></i>
            <span>Email</span>
        </div>
        <div class="sharer-button" data-sharer="whatsapp" data-title="{{ $title }}" data-url="{{ $url }}">
            <i class="bi bi-whatsapp"></i>
            <span>WhatsApp</span>
        </div>
        <div class="sharer-button" data-sharer="facebook" data-url="{{ $url }}">
            <i class="bi bi-facebook"></i>
            <span>Facebook</span>
        </div>
        <div class="sharer-button" data-sharer="twitter" data-title="{{ $title }}" data-url="{{ $url }}">
            <i class="bi bi-twitter-x"></i>
            <span>X</span>
        </div>
        <div class="sharer-button" data-sharer="threads" data-title="{{ $title }}" data-url="{{ $url }}">
            <i class="bi bi-threads"></i>
            <span>Threads</span>
        </div>
        <div class="sharer-button" data-sharer="linkedin" data-url="{{ $url }}">
            <i class="bi bi-linkedin"></i>
            <span>LinkedIn</span>
        </div>
        <div class="sharer-button" data-sharer="telegram" data-title="{{ $title }}" data-url="{{ $url }}">
            <i class="bi bi-telegram"></i>
            <span>Telegram</span>
        </div>
        <div class="sharer-button" data-sharer="reddit" data-title="{{ $title }}" data-url="{{ $url }}">
            <i class="bi bi-reddit"></i>
            <span>Reddit</span>
        </div>
    </div>
</div>
<script src="{{ asset('site/lib/sharer/sharer.min.js') }}"></script>