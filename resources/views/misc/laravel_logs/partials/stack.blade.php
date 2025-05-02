@if ($stack)
    <!-- Action button to trigger modal -->
    <div class="action-btns">
        <button class="view-btn btn btn-sm btn-light" onclick="openStackModal({{ $id }})" title="View Stack Trace" data-bs-toggle="tooltip">
            <i class="bi bi-eye text-primary"></i>
        </button>
    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="stackModal-{{ $id }}" tabindex="-1" aria-labelledby="stackModalLabel-{{ $id }}" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stackModalLabel-{{ $id }}">Stack Trace</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="stack-trace-container">
                        <button type="button" class="copy-btn" onclick="copyStackTrace({{ $id }})">
                            <i class="bi bi-clipboard"></i> Copy
                        </button>
                        <pre id="stack-content-{{ $id }}" class="bg-dark text-light p-3 rounded" style="white-space: pre-wrap; max-height: 500px; overflow-y: auto;">{{ $stack }}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.openStackModal = function(id) {
            var modalId = 'stackModal-' + id;
            var modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
        }
        
        window.copyStackTrace = function(id) {
            const stackElem = document.getElementById('stack-content-' + id);
            navigator.clipboard.writeText(stackElem.textContent).then(function() {
                toastr.success('Stack trace copied to clipboard');
            }, function() {
                toastr.error('Failed to copy stack trace');
            });
        }
    </script>
@else
    <span class="text-muted">No stack trace available</span>
@endif