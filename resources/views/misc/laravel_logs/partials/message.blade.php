<div class="message-truncate" id="message-{{ $id }}">{{ $message }}</div>

<!-- Action button to trigger modal -->
<div class="action-btns">
    <button class="view-btn btn btn-sm btn-light" onclick="openMessageModal({{ $id }})" title="View Full Message" data-bs-toggle="tooltip">
        <i class="bi bi-eye text-primary"></i>
    </button>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="messageModal-{{ $id }}" tabindex="-1" aria-labelledby="messageModalLabel-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel-{{ $id }}">Full Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="position-relative">
                    <button type="button" class="btn btn-sm btn-light position-absolute top-0 end-0 m-2" onclick="copyMessage({{ $id }})">
                        <i class="bi bi-clipboard"></i> Copy
                    </button>
                    <pre id="message-content-{{ $id }}" style="white-space: pre-wrap; word-break: break-word; background-color: #f8f9fa; padding: 15px; border-radius: 5px; max-height: 500px; overflow-y: auto;">{{ $message }}</pre>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.openMessageModal = function(id) {
        var modalId = 'messageModal-' + id;
        var modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();
    }
    
    window.copyMessage = function(id) {
        const messageElem = document.getElementById('message-content-' + id);
        navigator.clipboard.writeText(messageElem.textContent).then(function() {
            toastr.success('Message copied to clipboard');
        }, function() {
            toastr.error('Failed to copy message');
        });
    }
</script>