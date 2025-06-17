<x-main-layout :title="'Document Details - ' . ($document->title ?? '')">
    @push('styles')
<style>
    .bg-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .document-info-table {
        font-size: 0.95rem;
    }
    
    .document-info-table .table-label {
        background-color: #f8f9fa;
        width: 25%;
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-right: 3px solid #e9ecef;
    }
    
    .document-info-table .table-value {
        padding: 1rem 1.5rem;
        vertical-align: middle;
    }
    
    .document-info-table tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease;
    }
    
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .card-header {
        border-bottom: none;
    }
    
    .badge {
        font-weight: 500;
        border-radius: 8px;
    }
    
    code {
        font-size: 0.9em;
        font-weight: 600;
        color: #495057;
    }
    
    .btn {
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    /* Attachment display styles */
    .attachment-preview {
        max-width: 100%;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        margin-top: 10px;
    }
    
    .attachment-image {
        max-width: 100%;
        height: auto;
        display: block;
        border-radius: 8px;
    }
    
    .attachment-pdf {
        width: 100%;
        height: 600px;
        border: none;
        border-radius: 8px;
    }
    
    .attachment-controls {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 10px;
    }
    
    @media print {
        .no-print {
            display: none !important;
        }
        
        .card {
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
        }
        
        .bg-gradient {
            background: #6c757d !important;
            color: white !important;
        }
        
        .attachment-pdf {
            display: none;
        }
    }
    
    @media (max-width: 768px) {
        .attachment-pdf {
            height: 400px;
        }
    }
</style>
@endpush
<div class="container mt-2">
    <x-slot name="breadcrumbTitle">
        Document Details
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">{{ $document->title }}</li>
    </x-slot>
    
    <div class="row document-details">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center no-print mb-4">
                <div></div>
                <button type="button" id="print-document" class="cw-btn">
                    Print Document
                </button>
            </div>

            <!-- Enhanced Document Details Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Document Information
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 document-info-table">
                            <tbody>
                                <tr class="border-bottom">
                                    <td class="table-label">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-card-heading text-primary me-2"></i>
                                            <strong>Document Type</strong>
                                        </div>
                                    </td>
                                    <td class="table-value">
                                        <span>
                                            {{ $document?->document_type ?? "N/A" }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="table-label">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-card-heading text-info me-2"></i>
                                            <strong>Title</strong>
                                        </div>
                                    </td>
                                    <td class="table-value">
                                        <span>
                                            {{ $document?->title ?? "N/A" }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="table-label">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-building text-success me-2"></i>
                                            <strong>Office</strong>
                                        </div>
                                    </td>
                                    <td class="table-value">
                                        <span>
                                            <a href="{{ route('positions.details', ['uuid' => $document->posting->user->uuid]) }}">{{ $document?->posting?->office?->name ?? "N/A" }}</a>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="table-label">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-text-paragraph text-success me-2"></i>
                                            <strong>Description</strong>
                                        </div>
                                    </td>
                                    <td class="table-value">
                                        <p class="mb-0 text-muted">
                                            {{ $document?->description ?? "No description available" }}
                                        </p>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="table-label">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-hash text-warning me-2"></i>
                                            <strong>Document Number</strong>
                                        </div>
                                    </td>
                                    <td class="table-value">
                                        <code class="bg-light px-2 py-1 rounded">
                                            {{ $document?->document_number ?? "N/A" }}
                                        </code>
                                    </td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="table-label">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calendar-event text-info me-2"></i>
                                            <strong>Issue Date</strong>
                                        </div>
                                    </td>
                                    <td class="table-value">
                                        @if($document?->issue_date)
                                            <span class="badge bg-info text-white px-3 py-2">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ $document->issue_date->format('d M Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">Not specified</span>
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $hasAttachments = $document->hasMedia('secure_document_attachments');
                                    $attachment = $hasAttachments ? $document->getFirstMedia('secure_document_attachments') : null;
                                    $attachmentUrl = $attachment ? $document->getFirstMediaUrl('secure_document_attachments') : null;
                                    $mimeType = $attachment ? $attachment->mime_type : null;
                                    $fileName = $attachment ? $attachment->name : null;
                                    $fileExtension = $attachment ? strtolower(pathinfo($attachment->name, PATHINFO_EXTENSION)) : null;
                                    
                                    $isImage = $mimeType && str_starts_with($mimeType, 'image/');
                                    $isPdf = $mimeType === 'application/pdf' || $fileExtension === 'pdf';
                                @endphp
                                @if($hasAttachments)
                                <tr>
                                    <td class="table-label">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-paperclip text-danger me-2"></i>
                                            <strong>Attachment</strong>
                                        </div>
                                    </td>
                                    <td class="table-value">
                                        <div class="attachment-controls">
                                            <a href="{{ $attachmentUrl }}" 
                                               class="btn btn-sm btn-outline-success" 
                                               target="_blank">
                                                <i class="bi bi-download me-2"></i>
                                                Download {{ $fileName }}
                                            </a>
                                            @if($isImage || $isPdf)
                                                <span class="badge bg-secondary">
                                                    {{ $isImage ? 'Image' : 'PDF' }} Preview Available
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if($isImage)
                                            <div class="attachment-preview">
                                                <img src="{{ $attachmentUrl }}" 
                                                     alt="{{ $fileName }}" 
                                                     class="attachment-image">
                                            </div>
                                        @elseif($isPdf)
                                            <div class="attachment-preview">
                                                <embed src="{{ $attachmentUrl }}" 
                                                       type="application/pdf" 
                                                       width="100%" 
                                                       height="600">
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
<script>
    $('#print-document').on('click', function() {
        $(".document-details").printThis({
            pageTitle: "Document Details - {{ $document->title }}",
            printContainer: true,
            loadCSS: true,
            removeInline: false
        });
    });
</script>
@endpush
</x-main-layout>