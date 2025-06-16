<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
@php
    $canUpdate = auth()->user()->can('updateField', $document);
    $canUpload = auth()->user()->can('uploadFile', $document);
@endphp
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<div class="row service_card-details">
    <div class="col-md-12">
        <button type="button" id="print-service_card-details" class="no-print btn btn-light text-gray-900 border border-gray-300 float-end me-2 mb-2">
            <span class="d-flex align-items-center">
                <i class="bi-print"></i>
                Print
            </span>
        </button>
    </div>
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <tr>
                <th class="table-cell">Document Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-document_type">{{ $document->document_type }}</span>
                    @if($canUpdate)
                    <select id="input-document_type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('document_type', {{ $document->id }})">
                        @foreach($cat['document_type'] as $document_type)
                        <option value="{{ $document_type }}" {{ $document->document_type == $document_type ? 'selected' : '' }}>{{ $document_type }}</option>
                        @endforeach
                    </select>
                    <button id="save-btn-document_type" class="btn btn-sm btn-light d-none" onclick="updateField('document_type', {{ $document->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('document_type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            
            <tr>
                <th class="table-cell"> Title</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-title">{{ $document->title }}</span>
                    <input type="text" id="input-title" value="{{ $document->title }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('title', {{ $document->id }})" />
                    <button id="save-btn-title" class="btn btn-sm btn-light d-none" onclick="updateField('title', {{ $document->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-title" class="no-print btn btn-sm edit-button" onclick="enableEditing('title')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>

            <tr>
                <th class="table-cell"> Document Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-document_number">{{ $document->document_number }}</span>
                    @if ($canUpdate && !in_array($document->status, ['Verified', 'Rejected']))
                    <input type="text" id="input-document_number" value="{{ $document->document_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('document_number', {{ $document->id }})" />
                    <button id="save-btn-document_number" class="btn btn-sm btn-light d-none" onclick="updateField('document_number', {{ $document->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-document_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('document_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell"> Issue Date</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-issue_date">{{ $document->issue_date }}</span>
                    @if ($canUpdate && !in_array($document->status, ['Verified', 'Rejected']))
                    <input type="date" id="input-issue_date" value="{{ $document->issue_date }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('issue_date', {{ $document->id }})" />
                    <button id="save-btn-issue_date" class="btn btn-sm btn-light d-none" onclick="updateField('issue_date', {{ $document->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-issue_date" class="no-print btn btn-sm edit-button" onclick="enableEditing('issue_date')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Description</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-description">{!! $document->description !!}</span>
                    @if ($canUpdate && !in_array($document->status, ['published', 'archived']))
                    <div class="mb-3 w-100">
                        <textarea name="description" id="input-description" class="form-control d-none" style="height:150px">{!! old('description', $document->description) !!}</textarea>
                    </div>
                    <button id="save-btn-description" class="btn btn-sm btn-light d-none" onclick="updateField('description', {{ $document->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-description" class="no-print btn btn-sm edit-button" onclick="enableEditing('description')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Attachment</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    @php
                    $hasAttachments = $document->hasMedia('secure_document_attachments');
                    $imageUrl = $hasAttachments ? $document->getFirstMediaUrl('secure_document_attachments') : null;
                    @endphp

                    @if($hasAttachments)
                    <a href="{{ $imageUrl }}" target="_blank" title="File" class="d-flex align-items-center gap-2">
                        View
                    </a>
                    @else
                    <span>Not Uploaded</span>
                    @endif

                    @if ($canUpload)
                    <div class="no-print">
                        <label for="attachment" class="btn btn-sm btn-light">
                            <span class="d-flex align-items-center">
                                <i class="bi-{{ $hasAttachments ? 'pencil-square' : 'plus-circle' }}"></i>&nbsp;
                                {{ $hasAttachments ? 'Update' : 'Add' }}
                            </span>
                        </label>
                        <input type="file" id="attachment" name="attachment" class="d-none file-input">
                    </div>
                    @endif
                </td>
            </tr>

        </table>
    </div>
</div>
<script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script>
    $(document).ready(function() {
        imageCropper({
            fileInput: '#attachment'
            , inputLabelPreview: '#attachment-label-preview'
            , aspectRatio: 2 / 3
            , onComplete: async function(file, input) {
                var formData = new FormData();
                formData.append('attachment', file);
                formData.append('_method', "PATCH");

                const url = "{{ route('admin.apps.documents.uploadFile', ':id') }}".replace(':id', '{{ $document->id }}');
                try {
                    const result = await fetchRequest(url, 'POST', formData);
                    if (result) {
                        $(input).closest('.modal').modal('toggle');
                    }
                } catch (error) {
                    console.error('Error during form submission:', error);
                }
            }
        });

    });

    $('#print-service_card-details').on('click', () => {
        $(".service_card-details").printThis({
            pageTitle: "Details of {{ $document->name }}",
            beforePrint() {
                document.querySelector('.page-loader').classList.remove('hidden');
            },
            afterPrint() {
                document.querySelector('.page-loader').classList.add('hidden');
            }
        });
    });

    function enableEditing(field) {
        $('#text-' + field).addClass('d-none');
        $('#input-' + field).removeClass('d-none');
        $('#save-btn-' + field).removeClass('d-none');
        $('#edit-btn-' + field).addClass('d-none');

        if (field === 'content') {
            var textarea = $('#input-' + field);
        }
    }

    async function updateField(field, id) {
        const newValue = (field === 'content') ? $('#input-' + field).summernote('code') : $('#input-' + field).val();
        const url = "{{ route('admin.apps.documents.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field
            , value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data);
        if (success) {

            $('#text-' + field).text(newValue);
            $('#input-' + field).addClass('d-none');
            $('#save-btn-' + field).addClass('d-none');
            $('#edit-btn-' + field).removeClass('d-none');
            $('#text-' + field).removeClass('d-none');
        }
    }

</script>
