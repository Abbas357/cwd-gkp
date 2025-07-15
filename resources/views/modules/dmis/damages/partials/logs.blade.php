<style>
    .logs-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e9ecef;
    }

    .logs-header h4 {
        margin: 0;
        color: #495057;
        font-size: 1.1rem;
    }

    .logs-header i {
        margin-right: 0.5rem;
        color: #6c757d;
    }

    .logs-count {
        background: #f8f9fa;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        color: #6c757d;
    }

    .no-logs {
        text-align: center;
        padding: 2rem;
        color: #6c757d;
    }

    .no-logs i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }

    .table-wrapper {
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .logs-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
    }

    .logs-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .logs-table th {
        background: #495057;
        color: white;
        padding: 0.75rem 0.5rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.85rem;
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logs-table th:last-child {
        border-right: none;
    }

    .logs-table td {
        padding: 0.75rem 0.5rem;
        border-right: 1px solid #e9ecef;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    .logs-table td:last-child {
        border-right: none;
    }

    .log-row {
        background: white;
        transition: background-color 0.2s ease;
    }

    .log-row:hover {
        background: #f8f9fa;
    }

    .log-row.latest {
        background: linear-gradient(90deg, rgba(0, 123, 255, 0.05), rgba(0, 123, 255, 0.02));
        border-bottom: 2px solid #007bff !important;
    }

    .log-row.latest td {
        border-bottom-color: #007bff;
    }

    /* Column widths */
    .timeline-col {
        width: 60px;
    }

    .date-col {
        width: 150px;
    }

    .length-col {
        width: 100px;
    }

    .status-col {
        width: 140px;
    }

    .nature-col {
        width: 200px;
    }

    .cost-col {
        width: 120px;
    }

    .timeline-cell {
        background: #f8f9fa !important;
        border-right: 2px solid #dee2e6 !important;
        text-align: center;
        position: relative;
    }

    .timeline-wrapper {
        position: relative;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .timeline-dot {
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        background: white;
        border: 2px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: bold;
        color: #6c757d;
        z-index: 2;
        position: relative;
    }

    .timeline-dot.active {
        background: #007bff;
        border-color: #007bff;
        color: white;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
    }

    .timeline-line {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 2px;
        height: 100%;
        background: #dee2e6;
        transform: translateX(-50%);
        z-index: 1;
    }

    .date-cell {
        position: relative;
    }

    .date-info {
        position: relative;
    }

    .date {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
        margin-bottom: 0.1rem;
    }

    .time {
        font-size: 0.75rem;
        color: #6c757d;
    }

    .latest-badge {
        position: absolute;
        right: -0.5rem;
        top: 0;
        background: #007bff;
        color: white;
        padding: 0.1rem 0.4rem;
        border-radius: 10px;
        font-size: 0.6rem;
        font-weight: 600;
    }

    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
    }

    .partially-damaged {
        background: #fff3cd;
        color: #856404;
    }

    .fully-damaged {
        background: #f8d7da;
        color: #721c24;
    }

    .nature-cell {
        font-size: 0.8rem;
        line-height: 1.3;
    }

    .cost-cell {
        font-weight: 600;
        color: #28a745;
        text-align: right;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table-wrapper {
            overflow-x: auto;
        }

        .logs-table {
            min-width: 700px;
        }

        .logs-table th,
        .logs-table td {
            padding: 0.5rem 0.3rem;
            font-size: 0.75rem;
        }

        .timeline-dot {
            width: 1.2rem;
            height: 1.2rem;
            font-size: 0.6rem;
        }

        .logs-header {
            flex-direction: column;
            gap: 0.5rem;
            text-align: center;
        }
    }

    @media print {
        .table-wrapper {
            max-height: none;
            overflow: visible;
        }

        .logs-table thead {
            position: static;
        }
    }
</style>

<div class="damage-logs">
    <div class="logs-header">
        <h4><i class="bi-clock-history"></i> Damage History</h4>
        <span class="logs-count">{{ $damage->logs->count() }} entries</span>
    </div>

    @if ($damage->logs->isEmpty())
        <div class="no-logs">
            <i class="bi-clipboard"></i>
            <p>No history available</p>
        </div>
    @else
        <div class="table-wrapper">
            <table class="logs-table">
                <thead>
                    <tr>
                        <th class="timeline-col">#</th>
                        <th class="date-col">Date & Time</th>
                        <th class="length-col">Length</th>
                        <th class="status-col">Status</th>
                        <th class="nature-col">Nature</th>
                        <th class="cost-col">Restoration</th>
                        <th class="cost-col">Rehabilitation</th>
                        <th class="cost-col">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($damage->logs as $index => $log)
                        <tr class="log-row {{ $index === 0 ? 'latest' : '' }}">
                            <td class="timeline-cell">
                                <div class="timeline-wrapper">
                                    <div class="timeline-dot {{ $index === 0 ? 'active' : '' }}">
                                        {{ $index === 0 ? '★' : $damage->logs->count() - $index }}
                                    </div>
                                    @if ($index < $damage->logs->count() - 1)
                                        <div class="timeline-line"></div>
                                    @endif
                                </div>
                            </td>

                            <td class="date-cell">
                                <div class="date-info">
                                    <div class="date">{{ $log->created_at->format('M j, Y') }}</div>
                                    <div class="time">{{ $log->created_at->format('g:i A') }}</div>
                                    @if ($index === 0)
                                        <span class="latest-badge">Latest</span>
                                    @endif
                                </div>
                            </td>

                            <td class="length-cell">
                                {{ $log->damaged_length ?: '-' }}
                            </td>

                            <td class="status-cell">
                                @if ($log->damage_status)
                                    <span
                                        class="status-badge {{ str_replace(' ', '-', strtolower($log->damage_status)) }}">
                                        {{ $log->damage_status }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>

                            <td class="nature-cell">
                                @php
                                    $damageNature = json_decode($log->damage_nature, true);
                                @endphp

                                @if (is_array($damageNature))
                                    <ul class="mb-0 ps-3">
                                        @foreach ($damageNature as $item)
                                            <li>{{ Str::limit($item, 35) }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ Str::limit($log->damage_nature, 35) ?: '-' }}
                                @endif
                            </td>

                            <td class="cost-cell">
                                {{ $log->approximate_restoration_cost ? '₨ ' . number_format($log->approximate_restoration_cost, 0) : '-' }}
                            </td>

                            <td class="cost-cell">
                                {{ $log->approximate_rehabilitation_cost ? '₨ ' . number_format($log->approximate_rehabilitation_cost, 0) : '-' }}
                            </td>
                            <td class="cost-cell">
                                {{ $log->remarks }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
