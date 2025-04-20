<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
@php
    $canUpdate = auth()->user()->can('updateField', $ProvincialOwnReceipt);
@endphp
<div class="row vehicles-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <tr>
                <th class="table-cell">Month</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-month">{{ $ProvincialOwnReceipt->month->format('F Y') }}</span>
                    @if ($canUpdate)
                    <input type="month" id="input-month" value="{{ $ProvincialOwnReceipt->month->format('Y-m') }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('month', {{ $ProvincialOwnReceipt->id }})" />
                    <button id="save-btn-month" class="btn btn-sm btn-light d-none" onclick="updateField('month', {{ $ProvincialOwnReceipt->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-month" class="no-print btn btn-sm edit-button" onclick="enableEditing('month')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">DDO Code</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-ddo_code">{{ $ProvincialOwnReceipt->ddo_code }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-ddo_code" value="{{ $ProvincialOwnReceipt->ddo_code }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('ddo_code', {{ $ProvincialOwnReceipt->id }})" />
                    <button id="save-btn-ddo_code" class="btn btn-sm btn-light d-none" onclick="updateField('ddo_code', {{ $ProvincialOwnReceipt->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-ddo_code" class="no-print btn btn-sm edit-button" onclick="enableEditing('ddo_code')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">District</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-district_id">{{ $ProvincialOwnReceipt->district->name ?? 'N/A' }}</span>
                    @if ($canUpdate)
                    <select id="input-district_id" class="d-none form-control" onchange="updateField('district_id', {{ $ProvincialOwnReceipt->id }})">
                        @foreach ($cat['districts'] as $district)
                        <option value="{{ $district->id }}" {{ $ProvincialOwnReceipt->district_id == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-district_id" class="btn btn-sm btn-light d-none" onclick="updateField('district_id', {{ $ProvincialOwnReceipt->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-district_id" class="no-print btn btn-sm edit-button" onclick="enableEditing('district_id')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-type">{{ $ProvincialOwnReceipt->type }}</span>
                    @if ($canUpdate)
                    <select id="input-type" class="d-none form-control" onchange="updateField('type', {{ $ProvincialOwnReceipt->id }})">
                        @foreach ($cat['receipt_type'] as $type)
                        <option value="{{ $type->name }}" {{ $ProvincialOwnReceipt->type == $type->name ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-type" class="btn btn-sm btn-light d-none" onclick="updateField('type', {{ $ProvincialOwnReceipt->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-type" class="no-print btn btn-sm edit-button" onclick="enableEditing('type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Amount</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-amount">{{ number_format($ProvincialOwnReceipt->amount, 2) }}</span>
                    @if ($canUpdate)
                    <input type="number" step="0.01" id="input-amount" value="{{ $ProvincialOwnReceipt->amount }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('amount', {{ $ProvincialOwnReceipt->id }})" />
                    <button id="save-btn-amount" class="btn btn-sm btn-light d-none" onclick="updateField('amount', {{ $ProvincialOwnReceipt->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-amount" class="no-print btn btn-sm edit-button" onclick="enableEditing('amount')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Remarks</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-remarks">{{ $ProvincialOwnReceipt->remarks }}</span>
                    @if ($canUpdate)
                    <textarea id="input-remarks" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('remarks', {{ $ProvincialOwnReceipt->id }})">{{ $ProvincialOwnReceipt->remarks }}</textarea>
                    <button id="save-btn-remarks" class="btn btn-sm btn-light d-none" onclick="updateField('remarks', {{ $ProvincialOwnReceipt->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-remarks" class="no-print btn btn-sm edit-button" onclick="enableEditing('remarks')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
<script>
    function enableEditing(field) {
        $('#text-' + field).addClass('d-none');
        $('#input-' + field).removeClass('d-none');
        $('#save-btn-' + field).removeClass('d-none');
        $('#edit-btn-' + field).addClass('d-none');

        if (field === 'remarks') {
            var textarea = $('#input-' + field);
            if (!textarea.data('summernote-initialized')) {
                textarea.summernote({
                    height: 300
                });
                textarea.data('summernote-initialized', true);
            }
        }
    }

    async function updateField(field, id) {
        const newValue = (field === 'remarks') ? $('#input-' + field).summernote('code') : $('#input-' + field).val();

        const url = "{{ route('admin.apps.porms.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field
            , value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data);
        if (success) {
            if (field === 'remarks') {
                $('#text-' + field).html(newValue);
                $('#input-' + field).summernote('destroy');
                $('#input-' + field).data('summernote-initialized', false);
            } else {
                $('#text-' + field).text(newValue);
            }
            $('#input-' + field).addClass('d-none');
            $('#save-btn-' + field).addClass('d-none');
            $('#edit-btn-' + field).removeClass('d-none');
            $('#text-' + field).removeClass('d-none');
        }
    }

</script>
