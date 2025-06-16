<style>
    .qr-display-container {
        background: #9bacf6;
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .qr-title {
        color: white;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 10px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        position: relative;
        z-index: 2;
    }

    .qr-subtitle {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        margin-bottom: 30px;
        position: relative;
        z-index: 2;
    }

    .qr-code-wrapper {
        background: white;
        border-radius: 16px;
        padding: 20px;
        display: inline-block;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        position: relative;
        z-index: 2;
        transition: transform 0.3s ease;
    }

    .qr-code-wrapper:hover {
        transform: translateY(-5px);
    }

    .qr-code-wrapper img {
        display: block;
        border-radius: 8px;
        max-width: 200px;
        height: auto;
    }

    .qr-info {
        margin-top: 20px;
        color: rgba(255, 255, 255, 0.9);
        font-size: 12px;
        position: relative;
        z-index: 2;
    }

    .verification-badge {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 8px 16px;
        font-size: 11px;
        color: white;
        margin-top: 15px;
        display: inline-block;
        backdrop-filter: blur(10px);
        position: relative;
        z-index: 2;
    }

    .qr-loading {
        width: 200px;
        height: 200px;
        background: #f0f0f0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .qr-loading::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
        animation: loading 1.5s infinite;
    }

    /* Copy Button Styles */
    .qr-actions {
        margin-top: 20px;
        position: relative;
        z-index: 2;
    }

    .qr-copy-btn {
        background: rgba(255, 255, 255, 0.9);
        color: #9bacf6;
        border: none;
        border-radius: 25px;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .qr-download-btn {
        background: rgba(255, 255, 255, 0.8);
    }

    .qr-copy-btn:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .qr-copy-btn:active {
        transform: translateY(0);
    }

    .qr-copy-btn.copied {
        background: #4CAF50;
        color: white;
    }

    .qr-copy-btn.copying {
        opacity: 0.7;
        cursor: not-allowed;
    }

    @keyframes loading {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    @media (max-width: 480px) {
        .qr-display-container {
            padding: 30px 20px;
        }
        
        .qr-title {
            font-size: 20px;
        }
        
        .qr-code-wrapper img {
            max-width: 160px;
        }

        .qr-copy-btn {
            padding: 10px 20px;
            font-size: 13px;
        }
    }
</style>

<div id="capture">
    <div class="qr-display-container">
        <h2 class="qr-title">
            <i class="fas fa-qrcode me-2"></i>
            {{ $title ?? 'QR Code' }}
        </h2>
        <p class="qr-subtitle">{{ $description ?? 'Scan to check authenticity' }}</p>
        
        <div class="qr-code-wrapper">
            <img src="{{ $qrCodeUri }}" alt="QR Code" id="qr-image">
        </div>

        <div class="qr-actions">
            <button class="qr-copy-btn" id="copyQrBtn">
                <i class="fas fa-copy"></i>
                <span class="btn-text">Copy QR Code</span>
            </button>
            <button class="qr-copy-btn qr-download-btn" id="downloadQrBtn" style="margin-left: 10px;">
                <i class="fas fa-download"></i>
                <span class="btn-text">Download</span>
            </button>
        </div>
    </div>
</div>

<script>
    const copyBtn = document.getElementById('copyQrBtn');
    const downloadBtn = document.getElementById('downloadQrBtn');
    const qrImage = document.getElementById('qr-image');

    // Copy functionality
    copyBtn.addEventListener('click', async function() {
        const btnText = copyBtn.querySelector('.btn-text');
        const btnIcon = copyBtn.querySelector('i');
        
        try {
            if (copyBtn.classList.contains('copying')) return;
            
            copyBtn.classList.add('copying');
            btnText.textContent = 'Copying...';
            btnIcon.className = 'fas fa-spinner fa-spin';

            if (navigator.clipboard && navigator.clipboard.write && window.isSecureContext) {
                await copyImageModern(copyBtn, btnText, btnIcon);
            } else {
                copyImageFallback(copyBtn, btnText, btnIcon);
            }
            
        } catch (err) {
            console.error('Copy failed: ', err);
            copyImageFallback(copyBtn, btnText, btnIcon);
        }
    });

    // Download functionality
    downloadBtn.addEventListener('click', function() {
        const btnText = downloadBtn.querySelector('.btn-text');
        const btnIcon = downloadBtn.querySelector('i');
        
        downloadBtn.classList.add('copying');
        btnText.textContent = 'Downloading...';
        btnIcon.className = 'fas fa-spinner fa-spin';
        
        downloadImage(downloadBtn, btnText, btnIcon);
    });

    async function copyImageModern(btn, text, icon) {
        try {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            canvas.width = qrImage.naturalWidth;
            canvas.height = qrImage.naturalHeight;
            ctx.drawImage(qrImage, 0, 0);
            
            canvas.toBlob(async function(blob) {
                try {
                    await navigator.clipboard.write([
                        new ClipboardItem({ 'image/png': blob })
                    ]);
                    showSuccess(btn, text, icon, 'Copied!', 'fas fa-check');
                } catch (err) {
                    throw err;
                }
            }, 'image/png');
            
        } catch (err) {
            throw err;
        }
    }

    function copyImageFallback(btn, text, icon) {
        try {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            canvas.width = qrImage.naturalWidth;
            canvas.height = qrImage.naturalHeight;
            ctx.drawImage(qrImage, 0, 0);
            
            const dataURL = canvas.toDataURL('image/png');
            const textArea = document.createElement('textarea');
            textArea.value = dataURL;
            textArea.style.position = 'fixed';
            textArea.style.opacity = '0';
            document.body.appendChild(textArea);
            textArea.select();
            
            try {
                const successful = document.execCommand('copy');
                document.body.removeChild(textArea);
                
                if (successful) {
                    showSuccess(btn, text, icon, 'Copied!', 'fas fa-check');
                } else {
                    showError(btn, text, icon, 'Try Right-Click', 'fas fa-mouse-pointer');
                }
            } catch (err) {
                document.body.removeChild(textArea);
                showError(btn, text, icon, 'Try Right-Click', 'fas fa-mouse-pointer');
            }
            
        } catch (err) {
            showError(btn, text, icon, 'Copy Failed', 'fas fa-exclamation-triangle');
        }
    }

    function downloadImage(btn, text, icon) {
        try {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            canvas.width = qrImage.naturalWidth;
            canvas.height = qrImage.naturalHeight;
            ctx.drawImage(qrImage, 0, 0);
            
            const dataURL = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            link.download = 'qr-code.png';
            link.href = dataURL;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showSuccess(btn, text, icon, 'Downloaded!', 'fas fa-check');
            
        } catch (err) {
            showError(btn, text, icon, 'Download Failed', 'fas fa-exclamation-triangle');
        }
    }

    function showSuccess(btn, text, icon, message, iconClass) {
        btn.classList.remove('copying');
        btn.classList.add('copied');
        text.textContent = message;
        icon.className = iconClass;
        
        setTimeout(() => {
            btn.classList.remove('copied');
            text.textContent = btn.id === 'copyQrBtn' ? 'Copy QR Code' : 'Download';
            icon.className = btn.id === 'copyQrBtn' ? 'fas fa-copy' : 'fas fa-download';
        }, 2000);
    }

    function showError(btn, text, icon, message, iconClass) {
        btn.classList.remove('copying');
        text.textContent = message;
        icon.className = iconClass;
        
        setTimeout(() => {
            text.textContent = btn.id === 'copyQrBtn' ? 'Copy QR Code' : 'Download';
            icon.className = btn.id === 'copyQrBtn' ? 'fas fa-copy' : 'fas fa-download';
        }, 3000);
    }
</script>