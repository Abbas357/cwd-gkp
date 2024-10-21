<style>
    .properties-table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
    }

    .no-changes-cell {
        padding: 8px;
        border: 1px solid #ddd;
    }

    .table-header {
        padding: 8px;
        border: 1px solid #ddd;
    }

    .old-value-header {
        background: #ff000011;
    }

    .new-value-header {
        background: #00ff0011;
    }

    .table-cell {
        padding: 8px;
        border: 1px solid #ddd;
    }
</style>

@php
    $properties = $row->properties;
@endphp

@if (empty($properties) || (!isset($properties['attributes']) && !isset($properties['old'])))
    <table class="properties-table">
        <tr>
            <td class="no-changes-cell">
                <strong>No changes recorded.</strong>
            </td>
        </tr>
    </table>
@else
    <!-- Action button to trigger modal -->
    <div class="action-btns">
        <i class="view-btn bi-eye bg-light text-primary" id="toggleProps-{{ $row->id }}" onclick="openModal({{ $row->id }})" title="View" data-bs-toggle="tooltip"></i>
    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="propertiesModal-{{ $row->id }}" tabindex="-1" aria-labelledby="propertiesModalLabel-{{ $row->id }}" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="propertiesModalLabel-{{ $row->id }}">Following Changes Recorded</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="properties-table">
                        <thead>
                            <tr>
                                <th class="table-header">Attribute</th>
                                @if (isset($properties['attributes']) && isset($properties['old']))
                                    <th class="table-header old-value-header">Old Value</th>
                                    <th class="table-header new-value-header">New Value</th>
                                @elseif (isset($properties['attributes']) && !isset($properties['old']))
                                    <th class="table-header new-value-header">Values</th>
                                @elseif (isset($properties['old']) && !isset($properties['attributes']))
                                    <th class="table-header old-value-header">Values</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($properties['attributes']) && isset($properties['old']))
                                {{-- Handle updates --}}
                                @foreach ($properties['attributes'] as $key => $newValue)
                                    {{-- Skip empty fields --}}
                                    @if ($newValue !== null || (isset($properties['old'][$key]) && $properties['old'][$key] !== null))
                                        <tr>
                                            <td class="table-cell"><strong>{{ $key }}</strong></td>
                                            <td class="table-cell">{{ $properties['old'][$key] ?? 'N/A' }}</td>
                                            <td class="table-cell">{{ $newValue ?? 'N/A' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @elseif (isset($properties['attributes']) && !isset($properties['old']))
                                {{-- Handle creation (only new values) --}}
                                @foreach ($properties['attributes'] as $key => $newValue)
                                    {{-- Skip empty fields --}}
                                    @if ($newValue !== null)
                                        <tr>
                                            <td class="table-cell"><strong>{{ $key }}</strong></td>
                                            <td class="table-cell">{{ $newValue }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @elseif (isset($properties['old']) && !isset($properties['attributes']))
                                {{-- Handle deletion (only old values) --}}
                                @foreach ($properties['old'] as $key => $oldValue)
                                    {{-- Skip empty fields --}}
                                    @if ($oldValue !== null)
                                        <tr>
                                            <td class="table-cell"><strong>{{ $key }}</strong></td>
                                            <td class="table-cell">{{ $oldValue }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    function openModal(id) {
        var modalId = 'propertiesModal-' + id;
        var modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();
    }
</script>
